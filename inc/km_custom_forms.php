<?php
session_start();

global $wpdb;
define (DB_PREFIX, $wpdb->prefix);

class Km_Custom_Forms
{
    public $form_name;
    public $form_args;
    public $table = DB_PREFIX 'km_forms';

    /* Class constructor */
    public function __construct($name, $args = array())
    {
        if (!isset($_SESSION["km_post_fields"])) 
        {
            $_SESSION['km_post_fields'] = array();
        }

        // Set some important variables self::beautify( $string )
        $this->form_name = self::uglify($name);
        $this->form_args = $args;
        add_action('save_post',array(&$this,'save_data'));
    }

    public function ajaxcontact_enqueuescripts()
    {
        wp_enqueue_script('ajaxcontact', ACFSURL.'/js/ajaxcontact.js', array('jquery'));
        wp_localize_script( 'ajaxcontact', 'ajaxcontactajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function add_action()
    {
        add_action('wp_enqueue_scripts', array($this,'ajaxcontact_enqueuescripts'));  
    }

    public function form_elements($custom_fields = null)
    {
        // Nonce field for some validation
        wp_nonce_field(plugin_basename(__FILE__), 'km_custom_form_'.$this->form_name);

        // Check the array and loop through it
        if($custom_fields)
        {
            // Loop through $custom_fields
            foreach($custom_fields as $label => $type)
            {
                $field_id_name = self::uglify($this->form_name.'_'.$label);
                $select = '';
                if(is_array($type))
                {
                    if (strtolower($type['type']) == 'select') 
                    {
                        // filter through them, and create options
                        $select .= "<select name='$field_id_name' class='widefat'>";
                        foreach ($type['options'] as $key => $option) 
                        {
                            $select .= "<option value='$key'> $option </option>";
                        }
                        $select .= "</select>";
                        array_push($_SESSION['km_post_fields'], $field_id_name);
                    }                    
                }
                else
                {                    
                    array_push($_SESSION['km_post_fields'], $field_id_name);
                }

                $lookup = array(
                    "text" => "<input type='text' name='$field_id_name' value='' class='widefat' />",
                    "textarea" => "<textarea name='$field_id_name' class='widefat' rows='10'></textarea>",
                    "checkbox" => "<input type='checkbox' name='$field_id_name' value=''/>",
                    "select" => isset($select) ? $select : '',
                    "file" => "<input type='file' class='widefat' name='$field_id_name' id='$field_id_name' />"
                );
                ?>

                <p>
                    <label><?php echo ucwords($label); ?></label>
                    <?php echo $lookup[is_array($type) ? $type['type'] : $type]; ?>
                </p>               
           <?php 
            }
        }
    }
    
    public function save_data()
    {
        global $wpdb;

        if(isset($_POST['km_custom_form_'.$this->form_name]) && ! wp_verify_nonce($_POST['km_custom_form_'.$this->form_name], plugin_basename(__FILE__))) 
        return false;

        if (isset($_POST)) 
        {
            $answers = array();
            foreach ($_SESSION['km_post_fields'] as $form_field) 
            {
                if (!empty($_FILES[$form_field]) ) 
                {
                    if ( !empty($_FILES[$form_field]['tmp_name']) ) 
                    {
                        $upload = wp_upload_bits($_FILES[$form_field]['name'], null, file_get_contents($_FILES[$form_field]['tmp_name']));

                        if (isset($upload['error']) && $upload['error'] != 0) 
                        {
                            wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
                        } 
                        else 
                        {
                            $answers[] = $upload['url'];
                            $answers[] = "( '{$this->form_name}', '{$form_field}', '{$upload['url']}', NOW() )";
                        }
                    }
               } 
               else 
               {
                    // Make better. Have to do this, because I can't figure
                    // out a better way to deal with checkboxes. If deselected,
                    // they won't be represented here, but I still need to
                    // update the value to false to blank in the table. Hmm...
                    if (!isset($_POST[$form_field])) $_POST[$form_field] = '';

                    $answers[] = "( '{$this->form_name}', '{$form_field}', '{$_POST[$form_field]}', NOW() )";
                }
            }

            $sql = "INSERT INTO $this->table `". join( '`, `' $_SESSION['km_post_fields']). "` VALUES ". join(',' $answers);

            if ($wpdb->query($wpdb->escape($sql))) 
            {
                return true;
            }
            return new WP_Error("broke", "Unexpected error occured while creating member!");
        }
    }

    public function email()
    {

    }

    public static function beautify($string)
    {
        return ucwords(str_replace('_',' ',$string));
    }

    public static function uglify($string)
    {
        return strtolower(str_replace(' ','_',$string));
    }
}