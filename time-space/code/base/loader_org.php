<?php

/* 
block screen if javascript disabled ## 
*/

        echo '
        <div id="load_base" onclick="ecoder_loaded_base();" title="click anywhere to enter Time-Space">
            <div class="loading">';
            
                // google ads ##
                if ( $_SESSION['google'] == 1 ) { // show ads ## 
                
                    include "google.ads.php";
                
                }
                
                echo '    
                <div class="one">
                    
                    <div class="logo">
                        <!-- <a href="/time-space/manage/rhksflwk/admin.html" title="click Time-Space Management System">-->
                            <img src="'.$code['skin_path'].'design/Time-Space.png" alt="click anywhere to enter Time-Space" border="0">
                        <!-- </a> -->
                    </div>
                    
                    <div class="about">
                        <h1>'.$code['name'].' '.$code['version'].'</h1>
                        <p><a href="/" title="HOME" target="_blank">HomePage Go</a> / <a href="/time-space/manage/rhksflwk/logout.php" title="Logout">Log-Out</a></p>
                    </div>
                    
                    <div class="enter">
							<a href="/time-space/manage/rhksflwk/admin.html" title="click Time-Space Board-manager System">
                            <img src="'.$code['skin_path'].'design/note.png" style="float: left; margin: 7px -42px 0px 39px; border: 0px; width: 88px; height: 36px;" alt="Board-manager System" />
							<span style="position:relative;float:left;left:-30px;bottom:0;width:50px;height:22px;padding:10px 0 0 0px;font-size:14px;line-height:14px;text-align:center;">Board-Manager</span>
							</a>
							<a href="#" title="click Time-Space File-manager System">
                            <img src="'.$code['skin_path'].'design/note.png" style="float: left; margin: 7px -42px 0px 39px; border: 0px; width: 88px; height: 36px;" alt="File-manager System" />
							<span style="position:relative;float:left;left:-30px;bottom:0;width:50px;height:22px;padding:10px 0 0 0px;font-size:14px;line-height:14px;text-align:center;">File-Manager</span>
							</a>
							<!--
							<a href="#" title="enter Time-Space">
								<img src="'.$code['skin_path'].'design/enter.png" alt="enter Time-Space" border="0" />
							</a>
							-->
                    </div>
               
               </div>
               <div class="two">
                    
                    <div class="how">
                        <h1>what Time-Space is</h1>
                        <p>Time-Space is an open-source web-based code editor, with real-time colour syntax highlighting, which allows multiple documents to be edited directly online at the same time. 
                    </div>         
                    
                    <div class="requires">
                        <h1>requirements</h1>
                        <p>Time-Space works with most standards compliant browsers which have javascript enabled. internet explorer 6 is not supported.</p>
                    </div> 
                    
                    <div class="shortcuts">
                        <h1>File-manager keyboard shortcuts</h1>                           
                            
                            <div class="one">
                                <h2>tree</h2>
                                <p><strong>home</strong> - ctrl + 1</p>
                                <p><strong>add file</strong> - ctrl + 2</p>
                                <p><strong>add folder</strong> - ctrl + 3</p>
                                <p><strong>hidden files</strong> - ctrl + 4</p>
                                <p><strong>file upload</strong> - ctrl + 5</p>
                                <p><strong>refresh</strong> - ctrl + 6</p>
                            </div>
                            
                            <div class="two">
                                <h2>editor</h2>
                                <p><strong>save</strong> - ctrl + s</p>
                                <p><strong>undo</strong> - ctrl + z</p>
                                <p><strong>redo</strong> - ctrl + y</p>
                                <p><strong>select all</strong> - ctrl + a</p>
                                <p><strong>find</strong> - ctrl + f</p>
                                <p><strong>replace</strong> - ctrl + r</p>
                            </div>

                    </div>                 
                    
                </div>
            </div>
        </div>';

?>