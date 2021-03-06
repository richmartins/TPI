<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="edit-container">
    <form action="<?= base_url() ?>auth/processAdd" method="post" enctype="multipart/form-data" >
        <div class="edit-form-container">
            <div class="edit-form">
                 <div id="edit-form-col-script"class="edit-form-col">
                    <span class="edit-form-header-text">NAME</span>
                    <input name="name" class="app-name" type="text" placeholder="My app..."/>
                </div>
                <div id="edit-form-col-script"class="edit-form-col">
                    <span class="edit-form-header-text">SCRIPTS</span>
                    <textarea class="edit-scripts-area" rows="20" cols="55" name="script" style="resize: vertical;" placeholder="#my new script"></textarea>
                </div>
                <div class="edit-form-col">
                    <span class="edit-form-header-text">IMAGES</span>
                    <label for="img">Click below to choose new image file to upload<br />Note that the image must be a <b>PNG</b> file and should be <b>512px</b> by <b>512px</b></label>
                    <input class="edit-form-upload-btn" id="input_file" type="file" name="img">
                </div>
                <input type="hidden" name="id" value="<?= $id ?>">
            </div>
            <div class="edit-container-btns">
                <input type="submit" class="edit-btn" href="<?= base_url() ?>" value="ADD">
                <a class="edit-btn" href="<?= base_url() ?>auth">CANCEL</a>
            </div>
        </div>
    </form>
</div>
