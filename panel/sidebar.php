<?php

session_start();
ob_start();
$pageTitle = 'Sidebar';

include('../config.php');
include('header.php');

if ($_POST['zapisz'] == 'ok') {
        zapisz();
        

} 
sidebar();
include('footer.php');


function sidebar()
{
        global $db, $meta_table;

        
        $meta = $db->query("SELECT * FROM $meta_table WHERE typ='sidebar'")->fetchArray();
       



                        echo '

<form action="sidebar.php" method="post" enctype="multipart/form-data" class="col-md-4 mb-4">

<textarea id="redactor_content" name="tresc">' . $meta['tresc'] . '</textarea>
<input type="submit" value="wyślij" />
<input type="hidden" name="zapisz" value="ok" />
</form>';
              
      
} //function

function zapisz(){
    global $db, $meta_table;

  
        $db->query("UPDATE $meta_table SET tresc=? WHERE typ='sidebar' LIMIT 1", $_POST['tresc']);
}
