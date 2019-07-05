<?php include "../header.php";?>
<div class="page" >
<script src="get_html_translation_table.js" type="text/javascript"></script>
<script src="htmlentities.js" type="text/javascript"></script>
<script src="htmlspecialchars.js" type="text/javascript"></script>
<script type="text/javascript">
/* handle multi spaces */
function getNonBreakingSpaces(str, p1, p2, offset, s) {
	var spaces = '';
	for(i = 0; i < str.length; i++) {
		spaces += '&nbsp;';
	}
	return spaces;
}
function convert(){
        var input=document.getElementById("input").value;
        var output=htmlspecialchars(htmlentities((input)));
        var output=output.replace(/\n/g, "<br />");
        //var output=output.replace(/\s/g, "&nbsp;");
        var output=output.replace(/( ){2,}/g,getNonBreakingSpaces);
        document.getElementById("resultP").innerHTML="<div id=\"result\">"+output+"</div>";
    }
    
</script>
<h1>
<a href="#" class="history-back"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    HTML to ASCII convertor<small class="on-right">component</small>
</h1>
<p>Enter data:</p>
           <textarea id="input" style="width:100%;height:200px;margin-bottom:10px;" name="input"></textarea>
           <button onClick="convert();return false" class="icon-download-2 on-right">Convert HTML into ASCII entities</button>
           <div id="resultP" class="bg-amber padding10" style="width:100%;min-height:100px;margin:10px 0;"></div>
<?php include "../footer.php";?>