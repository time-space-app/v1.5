<?php

/* 
block screen if javascript disabled ## 
*/
if($_SESSION['valid_level'] == 1){
        echo '
        <div id="load_base">
            <div class="loading">    
                <div class="one" onclick="ecoder_loaded_base();" style="cursor:pointer;background-color:skyblue;">                  
                    <div class="logo">
                             <h1 style="font-size:60px;">FILE</h1><br/>
                             <span class="icon-folder-2" style="background: red; color: white; padding: 40px; border-radius: 50%;font-size:120px;"></span>
                             <h1 style="font-size:30px;">ENTER</h1>
                    </div>                 
               </div>
               <div class="one" onclick="location.replace(\'/time-space/manage/rhksflwk/admin.html\')" style="background-color:yellow;cursor:pointer;">                  
                    <div class="logo">
                             <h1 style="font-size:60px;">BOARD</h1><br/>
                             <span class="icon-keyboard" style="background: blue; color: white; padding: 40px; border-radius: 50%;font-size:120px;"></span>
                             <h1 style="font-size:30px;">ENTER</h1>
                    </div>                          
               </div>
               <div style="clear:both;text-align:center;width:600px;">
                        <h2><img src="'.$code['skin_path'].'design/Time-Space.png" style="width:40px"> <span> '.$code['name'].' '.$code['version'].'</span></h2>
                        <h1><span class="icon-home" style="color:blue"><a href="/" title="HOME" target="_blank">HomePage Go</a></span> | <span class="icon-unlocked" style="color:blue"><a href="/time-space/manage/rhksflwk/logout.php" title="Logout">Log-Out</a></span></h1>
               </div>
               
            </div>
        </div>';
}else{
        echo '
        <div id="load_base">
            <div class="loading">
            	<div class="one" style="cursor:pointer;background-color:skyblue;">                  
                    <div class="logo">
                    </div>                 
               </div>    
               <div class="one" onclick="location.replace(\'/time-space/manage/rhksflwk/admin.html\')" style="background-color:yellow;cursor:pointer;">                  
                    <div class="logo">
                             <h1 style="font-size:60px;">BOARD</h1><br/>
                             <span class="icon-keyboard" style="background: blue; color: white; padding: 40px; border-radius: 50%;font-size:120px;"></span>
                             <h1 style="font-size:30px;">ENTER</h1>
                    </div>                          
               </div>
               <div style="clear:both;text-align:center;width:600px;">
                        <h2><img src="'.$code['skin_path'].'design/Time-Space.png" style="width:40px"> <span> '.$code['name'].' '.$code['version'].'</span></h2>
                        <h1><span class="icon-home" style="color:blue"><a href="/" title="HOME" target="_blank">HomePage Go</a></span> | <span class="icon-unlocked" style="color:blue"><a href="/time-space/manage/rhksflwk/logout.php" title="Logout">Log-Out</a></span></h1>
               </div>
               
            </div>
        </div>';
}
?>