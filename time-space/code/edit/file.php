<?php

/*
main editor ##
*/

// default ##
$main['content'] = $code['root'].'/'.$main['path'].'/'.$main['file'];

// check if file and path exists ##
if ( file_exists ( $main['content'] ) ) {

    // get contents ##
    $main['content'] = file_get_contents( $main['content'] );

} // exists ##

// build text area ##
if ( $_SESSION['editor'] == "delux" ) {  // edit_area ##
$save['contents'] = 'editAreaLoader.getValue( \'editarea\' );'; // function to get textarea contents ## --

echo '
<textarea id="editarea" name="content" style="width: 100%; height: 100%; padding: 0px; margin: 0px;">'.trim ( htmlspecialchars($main['content']) ).'</textarea>';


} elseif ( $_SESSION['editor'] == "basic" ) {
$save['contents'] = 'CKEDITOR.instances[\'codepress\'].getData();'; // function to get textarea contents ## --
echo '
<textarea id="codepress" class="codepress '.$main['type'].' '.$codepress['options'].'" style="width: 100%; height:100%; padding: 0px; margin: 0px;" wrap="on">
'.trim ( $main['content'] ).'
</textarea>';
echo '
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/time-space/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<link rel="stylesheet" type="text/css" href="/time-space/ckeditor/plugins/codesnippet/lib/highlight/styles/googlecode.css" />
<script type="text/javascript">
CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g);
CKEDITOR.config.docType = "<!DOCTYPE html>";
CKEDITOR.config.contentsCss = ["/_metro/css/metro-bootstrap.css"];
CKEDITOR.config.bodyClass = "metro";
CKEDITOR.editorConfig = function( config ) {
config.extraPlugins = "codesnippet,lineutils,widget";
config.codeSnippet_theme = "googlecode";
config.extraPlugins = "codesnippet";
};
CKEDITOR.replace( "codepress",
		    {
		    height: 700,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images",
        toolbar : "Basic"
		    });
CKEDITOR.replace( "codepress", config );
</script>
';
} // text area options ##


// include save script ##
$save['target'] = 'code/save/edit.php'; // file to process save ##
if ( $main['nav']['save'] == 1 ) { // save active ##
include "save.php"; }

?>
