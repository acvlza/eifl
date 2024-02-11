<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>js/plugins/summernote/summernote-lite.css">
<script src="<?= base_url(); ?>js/plugins/summernote/summernote-lite.js"></script>

<?php echo form_open('emails/save/' . $email_info->email_id, array('id' => 'email_form', 'class' => 'form-horizontal')); ?>

<style>
    .btn, .btn:hover {
        color: #4f5f6f;
    }
</style>

<div class="title-block">
    <h3 class="title"> 

        <?php if ($email_info->email_id > 0): ?>
            <?=ktranslate2("Update email template")?>
        <?php else: ?>
            <?=ktranslate2("New email template");?>
        <?php endif; ?>

    </h3>
    <p class="title-description">
        <?= ktranslate2("Email template basic information")?>
    </p>
</div>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inqbox float-e-margins">
                                <div class="inqbox-content">
                                    <div style="text-align: center">
                                        <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                        <ul id="error_message_box"></ul>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">
                                            <?= ktranslate2("Template Name")?>:
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="template_name" id="template_name" value="<?= $email_info->template_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">
                                            <?= ktranslate2("Email Subject")?>:
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="template_subject" id="template_subject" value="<?= $email_info->template_subject; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">
                                            <?= ktranslate2("Placeholder")?>:
                                        </label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="sel-placeholder">
                                                <option value="">Choose</option>
                                                <option value="{person_name}"><?=ktranslate2("Person name")?></option>
                                                <option value="{company_name}"><?=ktranslate2("Company name")?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label required">
                                            <?=ktranslate2("Template")?>:
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control template" style="height: 150px" name="template" id="template"><?= $email_info->templates; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label required">
                                            <?= ktranslate2("Descriptions")?>:
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" style="height: 80px" name="descriptions" id="descriptions"><?= $email_info->descriptions; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">

                        <button type="button" class="btn btn-default btn-secondary" data-dismiss="modal" id="btn-close"><?= $this->lang->line("common_close"); ?></button>
                        <?php
                        echo form_submit(
                                array(
                                    'name' => 'submit',
                                    'id' => 'submit',
                                    'value' => $this->lang->line('common_submit'),
                                    'class' => 'btn btn-primary'
                                )
                        );
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<input type="hidden" id="hid-template" name="hid-template" value="" />

<?php
echo form_close();
?>

<?php $this->load->view("partial/footer"); ?>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function () {
        init_settings();
        
        $('.template').summernote({height: 150});
        $('#sel-placeholder').change(function(){
            $("#template").summernote('editor.restoreRange');
            $("#template").summernote('editor.focus');
            $("#template").summernote('editor.insertText', $(this).val());
        });
    });


    function init_settings() {
        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
                $("#hid-template").val($('.template').val());

                $(form).ajaxSubmit({
                    success: function (response) {
                        post_message_form_submit(response);
                        $("#submit").prop("disabled", false);
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                template_name: "required",
                template: "required"
            },
            messages: {
                template_name: "Template name is required!",
                template: "Template is required!",
            }
        };

        $('#email_form').validate(settings);

        function post_message_form_submit(response) {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            } else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $("#email_form").attr("action", "<?= site_url(); ?>messages/save/" + response.email_id);
        }
    }

</script>