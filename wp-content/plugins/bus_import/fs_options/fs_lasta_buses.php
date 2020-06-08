<?php

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
	?>
    
<script type="text/javascript">
alert('Promenili ste temu!');
</script><?php }
/* Include script and style files */
if(is_admin())
	{
		global $wpdb;
		wp_enqueue_style('thickbox');
		wp_enqueue_style('fs_style_css', FS_OPTIONS_URL . 'jscss/style.css');
		wp_enqueue_style('color_picker_css', FS_OPTIONS_URL . 'jscss/colorpicker.css');
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('color_picker_js', FS_OPTIONS_URL . 'jscss/colorpicker.js');
		wp_enqueue_script('fs_functions', FS_OPTIONS_URL . 'jscss/fs_functions.js');
		wp_enqueue_script('fs_slider_manager', FS_OPTIONS_URL . 'jscss/fs_slider_manager.js');
		
		wp_enqueue_script('serialize', get_bloginfo('template_url') . '/js/serialize.js');
		require_once 'ThumbLib.inc.php';
	}

add_action( 'admin_menu', 'lasta_buses');
function lasta_buses() 
    {
	    //add_menu_page('Lasta Autobusi', 'Lasta Autobusi', 'manage_lasta_buses', 'all_lasta_buses', 'all_lasta_buses');    
	    //add_submenu_page('all_lasta_buses', 'Unos/Edit Vozila', 'Unos/Edit Vozila', 'manage_lasta_buses', 'new_edit_vehicle', 'new_edit_vehicle');
	    //add_submenu_page('all_lasta_buses', 'Kategorije vozila', 'Kategorije vozila', 'manage_lasta_buses', 'vehicle_cats_edit', 'vehicle_cats_edit');
    }

function all_lasta_buses()
    {
        global $wpdb;
    	if (isset($_GET["d_id"]))
    	   {
    	   	   $img = $wpdb->get_row("SELECT image
                                                      FROM vehicles
                                                      WHERE id='".esc_sql($_GET["d_id"])."'");
    	   	   
    	   	   @unlink(FS_OPTIONS_PATH."bus_images/{$img ->image}");
    	   	   $wpdb->delete("vehicles",array('id'=>esc_sql($_GET["d_id"])));
    	   }

        $vehicles = $wpdb->get_results("SELECT vehicles.id as v_id,vehicles.vehicle_category,title,
                                 manufacturer,capacity,equipment,number_of_vehicles,image,vehicles_categories.vehicle_category as cat_name
                                 FROM vehicles
                                 INNER JOIN vehicles_categories
                                 ON vehicles_categories.id = vehicles.vehicle_category");

        ?>
        
        <table class = "widefat" style="width:400px">
            <tr>
                <td align="center" colspan="15"><span style = "font-size:20px; font-weight:bold;" >Svi Lasta Autobusi</span></td>
            </tr><?php
	    	foreach ($vehicles as $v)
	    	   {?>
			        <tr>
			             <td><?php 
			                 echo $v ->cat_name;?>
			             </td>
			             <td><?php 
                             echo $v ->title;?>
                         </td>
                         <td><?php 
                             echo $v ->manufacturer;?>
                         </td>
                         <td><?php 
                             echo $v ->capacity;?>
                         </td>
                         <td><?php 
                             echo $v ->equipment;?>
                         </td>
                         <td><?php 
                             echo $v ->number_of_vehicles;?>
                         </td>
                         <td><?php 
                            if (isset($v ->image) && $v ->image != "")
                                {?>
                                    <img width="45" height="35" src="<?php echo bloginfo("template_url")."/fs_options/bus_images/{$v ->image}";?>" /><?php 
                                }?>
                         </td>
                         <td>
                            <a href="admin.php?page=new_edit_vehicle&v_id=<?php echo $v ->v_id;?>">Izmeni</a>
                         </td>
                         <td>
                            <a href="admin.php?page=all_lasta_buses&d_id=<?php echo $v ->v_id;?>"  onclick="javascript:return confirm('Da liste sigurni?');">Obriši</a>
                         </td>
			        </tr><?php 
	    	   }?>
    	</table><?php 
    }
function new_edit_linija(){
	global $wpdb;

	$linija_id = $_POST['linija_id'];
	$opis = $_POST['opis'];
	$info = $_POST['info'];
	$info_kontakt = $_POST['info_kontakt'];

	$rb = $_POST['rb'];
	$stajaliste_rb = $_POST['stajaliste_rb'];

	$dolazak = $_POST['dolazak'];
	$ponedeljak = $_POST['ponedeljak'];
	$utorak = $_POST['utorak'];
	$sreda = $_POST['sreda'];
	$cetvrtak = $_POST['cetvrtak'];
	$petak = $_POST['petak'];
	$subota = $_POST['subota'];
	$nedelja = $_POST['nedelja'];
	$praznik = $_POST['praznik'];

	$naziv = $_POST['naziv'];
	$stajaliste_info = $_POST['stajaliste_info'];
	$km = $_POST['km'];	
	$vreme = $_POST['vreme'];
	$stajaliste_id = $_POST['stajaliste_id'];
	$polazak_arr = $_POST['polazak_id'];


	$wpdb->query('UPDATE lb1706wp_lasta_linija SET 
		`opis` = "'. esc_sql($opis) .'",
		`info` = "'. esc_sql($info) .'",
		`info_kontakt` = "'. esc_sql($info_kontakt) .'"
		WHERE `id` = "'. esc_sql($linija_id) . '"');

	foreach($rb as $i=>$b) { 
		$wpdb->query('UPDATE lb1706wp_lasta_polazak SET 
			`dolazak` = "'. esc_sql($dolazak[$i]) .'",
			`pon` = "'. esc_sql($ponedeljak[$i]) .'",
			`uto` = "'. esc_sql($utorak[$i]) .'",
			`sre` = "'. esc_sql($sreda[$i]) .'",
			`cet` = "'. esc_sql($cetvrtak[$i]) .'",
			`pet` = "'. esc_sql($petak[$i]) .'",
			`sub` = "'. esc_sql($subota[$i]) .'",
			`ned` = "'. esc_sql($nedelja[$i]) .'",
			`praznik` = "'. esc_sql($praznik[$i]) .'"
			WHERE rb = "'. esc_sql($b) .'" AND `linija_id` = "'. esc_sql($linija_id) . '"');
	}


	foreach ($naziv as $key=>$n) { //stajaliste
        //var_dump($key);
        //var_dump($n);
        $local_rb = (int)$stajaliste_rb[$key];
		//var_dump($local_rb);
		//var_dump($linija_id);
		$stajaliste_id = $stajaliste_id[$key];

		$wpdb->query('UPDATE lb1706wp_lasta_stajaliste SET 
			`naziv` = "' . esc_sql($n) . '",
			`info` = "' . esc_sql($stajaliste_info[$key]) . '",
			`km` = "' . $km[$key] . '",
			`rb` = "' . esc_sql($local_rb) . '"
			WHERE `rb` = "' . esc_sql($local_rb) . '" AND `linija_id` = "'. esc_sql($linija_id) . '"');
		
        foreach ($polazak_arr as $key2 => $polazak_id) { //polazak

            $new_vreme = $vreme[$polazak_id][$stajaliste_id];

            $wpdb->query('UPDATE lb1706wp_lasta_termin SET vreme = "'. esc_sql($new_vreme) .'" WHERE stajaliste_id = "' . esc_sql($stajaliste_id) . 
                    '" AND polazak_id = "' . $polazak_id . '"'); 
        }

	}

    echo "<center><p>Uspesno ste izmenili podatke za liniju: " . $linija_id.'<p>';
    echo "<p>Vratite se <a href='http://lasta.titandizajn.com/wp-admin/admin.php?page=lasta-view&linija_id=".$_POST['linija_id']."'>nazad</a></p></center>";

}
add_action( 'admin_post_new_edit_linija', 'new_edit_linija');
add_action( 'admin_post_nopriv_new_edit_linija', 'new_edit_linija');

add_action('wp_ajax_data_search' , 'data_search');
add_action('wp_ajax_nopriv_data_search','data_search');

function data_search(){
    global $wpdb;
    $keyword = mb_strtoupper($_POST['keyword']);
    $tip = $_POST['tip'];

    //var_dump($tip);

    $sql = $wpdb->prepare('SELECT * FROM lb1706wp_lasta_grad where naziv like %s and '.$tip.' = 1',
    '%'.$keyword.'%');

    $results = $wpdb->get_results($sql . ' ORDER BY lb1706wp_lasta_grad.naziv ASC');
    //var_dump($results);
    $html .= '<ul>';
    foreach ($results as $key => $row) {
        $html .= '<li data-id="'.$row->id.'">'.$row->naziv.'</li>';
    }
    $html .= '</ul>';
    echo $html;

    die();
}


function new_edit_vehicle()
    {
        global $wpdb;
    	$edit_id = (isset($_GET["v_id"])) ? $_GET["v_id"] : "";
    	
        if (isset($_POST["form_submit"]))
            {     
                $img = get_row("SELECT image
                                                       FROM vehicles
                                                       WHERE id='".esc_sql($_POST["edit"])."'");
                $img_del  = $img ->image;
                $img_name = $img ->image;
                
            	if (preg_match("/.jpg|.jpeg|.png/i",basename($_FILES["img"]['name'],$matched)))
                    {
                        $img_name = rand(0,9999).time();
                    	$img_ext  = substr(basename($_FILES["img"]['name']),strpos(basename($_FILES["img"]['name']),"."));
                    	$img_name = $img_name.$img_ext;
                    	
		            	$thumb    = PhpThumbFactory::create($_FILES["img"]['tmp_name'],array("correctPermissions" => true));
		                $thumb ->adaptiveResize(145, 125);
		                $thumb ->save(FS_OPTIONS_PATH."bus_images/$img_name");
                    }
                if (isset($_POST["form_submit"]) && $_POST["edit"] == "")
                    {
		                $wpdb->query("INSERT INTO vehicles
		                             (vehicle_category,title,manufacturer,capacity,equipment,number_of_vehicles,image)
		                             VALUES 
		                             ('".esc_sql($_POST["vehicle_category"])."','".esc_sql($_POST["title"])."',
		                              '".esc_sql($_POST["manufacturer"])."','".esc_sql($_POST["capacity"])."',
		                              '".esc_sql($_POST["equipment"])."','".esc_sql($_POST["number_of_vehicles"])."',
		                              '$img_name')");
		                              
		                $edit_id = mysql_insert_id();
                    }
                else 
                    {
                    	if ((isset($_POST["img_del"]) && $_POST["img_del"] == "on") ||
                    	    (preg_match("/.jpg|.jpeg|.png/i",basename($_FILES["img"]['name'],$matched)) && $img_del != ""))
                    	   {
                    	   	   unlink(FS_OPTIONS_PATH."bus_images/$img_del");
                    	   	   $img_name = (isset($_POST["img_del"]) && $_POST["img_del"] == "on") ? "" : $img_name;
                    	   }
                    	   
                    	$wpdb->query("UPDATE vehicles
                    	             SET vehicle_category = '".esc_sql($_POST["vehicle_category"])."',
                    	                 title = '".esc_sql($_POST["title"])."',
                    	                 manufacturer = '".esc_sql($_POST["manufacturer"])."',
                    	                 capacity = '".esc_sql($_POST["capacity"])."',
                    	                 equipment = '".esc_sql($_POST["equipment"])."',
                    	                 number_of_vehicles = '".esc_sql($_POST["number_of_vehicles"])."',
                    	                 image = '$img_name'
                    	             WHERE id = '".esc_sql($_POST["edit"])."'");
                    	$edit_id = $_POST["edit"];
                    }
                
            }
        if ($edit_id != "")
            {
            	$v_data = $wpdb->get_row("SELECT vehicles.id as v_id,vehicles.vehicle_category,title,manufacturer,capacity,
            	                                          equipment,number_of_vehicles,image
						                                  FROM vehicles
						                                  INNER JOIN vehicles_categories
						                                  ON vehicles_categories.id = vehicles.vehicle_category
						                                  WHERE vehicles.id = '".esc_sql($edit_id)."'");
            }?>
            
    	<table class = "widefat" style="width:600px"><?php 
            if (isset($_POST["form_submit"]) || isset($_GET["v_id"]))
                {?>
                    <tr>
                       <td align="center">
                           <span style = "font-size:20px; font-weight:bold;" ><i>Snimljeno</i></span>
                       </td>
                    </tr><?php 
                }?>
            <tr>
                <td align="center"><span style = "font-size:20px; font-weight:bold;" >Unos Novog Vozila</span></td>
            </tr>
        </table>
        <form action="admin.php?page=new_edit_vehicle" method="post" name="new_vehicle" enctype="multipart/form-data">
            <table class = "widefat" style="width:600px">
                <tr>
                   <th scope = "row" width = "150px">Naziv Vozila: </th>
                   <td>
                        <input type="text" name="title" value="<?php echo (isset($v_data ->title)) ? $v_data ->title : '';?>"/>
                   </td>
                </tr>
                <tr><?php 
                    $cats = $wpdb->get_results("SELECT * 
                                         FROM vehicles_categories
                                         ORDER BY vehicle_category DESC");?>
                   <th scope = "row" width = "150px">Kategorija Vozila: </th>
                   <td>
                        <select name="vehicle_category"><?php 
                        foreach ($cats as $c)
                            {?>
                            	<option value="<?php echo $c ->id;?>" <?php echo ($c ->id == $v_data ->vehicle_category) ? "selected='selected'": '';?>><?php echo $c ->vehicle_category;?></option><?php 
                            }?>
                        </select>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Proizvođač: </th>
                   <td>
                        <input type="text" name="manufacturer" value="<?php echo (isset($v_data ->manufacturer)) ? $v_data ->manufacturer : '';?>"/>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Kapacitet: </th>
                   <td>
                        <input type="text" name="capacity" value="<?php echo (isset($v_data ->capacity)) ? $v_data ->capacity : '';?>"/>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Oprema: </th>
                   <td>
                        <input type="text" name="equipment" value="<?php echo (isset($v_data ->equipment)) ? $v_data ->equipment:'' ;?>"/>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Broj vozila: </th>
                   <td>
                        <input type="text" name="number_of_vehicles" value="<?php echo (isset($v_data ->number_of_vehicles)) ? $v_data ->number_of_vehicles : '';?>"/>
                   </td>
                </tr>
                <tr>
                   <th scope = "row" width = "150px">Slika vozila: </th>
                   <td>
                        <input type="file" name="img" /><?php
                        if (isset($v_data ->image) && $v_data ->image != "")
	                        {?>
	                        	<img src="<?php echo bloginfo("template_url")."/fs_options/bus_images/{$v_data ->image}";?>" width="45" height="35"/>
	                        	<label>Del img<input type="checkbox" name="img_del" /></label><?php 
	                        }?>
                        
                   </td>
                </tr>
                <tr>
                    <td colspan='10' align='center'>
                        <input type = "submit" class = "button-secondary action" id = "submit_providers_form" value = "Sačuvaj" name="form_submit"/>
                        <input type="hidden" name="edit" value="<?php echo $edit_id;?>"/>
                    </td>
                </tr>                           
             </table>
         </form><?php
    }
function vehicle_cats_edit()
    {   
        global $wpdb;
    	#category edit id
    	$cat = (isset($_GET["cat_id"])) ? $_GET["cat_id"] : '';
    	
    	if (isset($_GET["del_id"]))
    	   {
    	   	   $wpdb->query("DELETE FROM vehicles_categories WHERE id='$cat'");
    	   }
    	if (isset($_POST["form_submit"]))
            {
            	if (isset($_POST["category_title"]) && $_POST["category_title"] != "" && $_POST["edit"] == "")
            	   {
		                $wpdb->query("INSERT INTO vehicles_categories
		                             (vehicle_category)
		                             VALUES 
		                             ('".esc_sql($_POST["category_title"])."')"); 
		                //$cat = mysql_insert_id();     
            	   }
            	else 
            	   {
            	   	   if ($_POST["edit"] != '')
            	   	       {
		            	   	   $wpdb->query("UPDATE vehicles_categories
		            	   	                SET vehicle_category = '".esc_sql($_POST["category_title"])."'
		            	   	                WHERE id='".esc_sql($_POST["edit"])."'");
            	   	       }
            	   }
            	           
            }
        if ($cat != "")
            {   
            	$cats = $wpdb->get_row("SELECT * FROM
					                                    vehicles_categories
					                                    WHERE id='".esc_sql($cat)."'");
            	$cat_title = $cats ->vehicle_category;
            	$cat       = $cats ->id;
            }?>
        <table class = "widefat" style="width:400px"><?php 
            if (isset($_POST["form_submit"]))
                {?>
                    <tr>
                       <td align="center">
                           <span style = "font-size:20px; font-weight:bold;" ><i>Snimljeno</i></span>
                       </td>
                    </tr><?php 
                }?>
            <tr>
                <td align="center"><span style = "font-size:20px; font-weight:bold;" >Unos Kategorija Vozila</span></td>
            </tr>
        </table>
        
        <form action="admin.php?page=vehicle_cats_edit" method="post" name="new_vehicle_cat" enctype="multipart/form-data">
            <table class = "widefat" style="width:400px">
                <tr>
                   <th scope = "row" width = "150px">Kategorija Vozila: </th>
                   <td>
                        <input type="text" name="category_title" value="<?php echo ($cat_title != "") ? $cat_title : '';?>"/>
                   </td>
                </tr>
                <tr>
                    <td colspan='10' align='center'>
                        <input type = "submit" class = "button-secondary action" id = "submit_providers_form" value = "Sačuvaj" name="form_submit"/>
                        <input type="hidden" name="edit" value="<?php echo $cat;?>"/>
                    </td>
                </tr>                           
             </table>
         </form><?php
         $cats = $wpdb->get_results("SELECT * FROM
                              vehicles_categories");
         ?>
		         <table class = "widefat" style="width:400px;margin-top:25px;">
                    <tr>
                        <td align="center" colspan="3"><span style = "font-size:20px; font-weight:bold;" >Sve kategorije</span></td>
                    </tr><?php 
				         foreach ($cats as $c)
				            {?>
                                <tr>
				            	   <td align="center">
				            	       <?php echo $c ->vehicle_category;?>
				            	   </td>
				            	   <td align="center">
                                       <a href="admin.php?page=vehicle_cats_edit&cat_id=<?php echo $c ->id;?>">Izmena</a>
                                   </td>
                                   <td align="center">
                                       <a href="admin.php?page=vehicle_cats_edit&del_id=1&cat_id=<?php echo $c ->id;?>" onclick="javascript:return confirm('Da li ste sigurni?');">Brisanje</a>
                                   </td>
                                </tr><?php 
				            }?>
				 </table><?php  
              	
    }