<?php $this->load->view("partial/header"); ?>

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>js/plugins/summernote/summernote.css">
<script src="<?= base_url(); ?>js/plugins/summernote/summernote.min.js"></script>


<?php echo form_open('messages/save/' . $message_info->message_id, array('id' => 'message_form', 'class' => 'form-horizontal')); ?>


<div class="title-block">
    <h3 class="title"> 

        <?=ktranslate2("My mail");?>

    </h3>
    <p class="title-description">
        <?=ktranslate2("Create mail");?>
    </p>
</div>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-block">

                    <div class="inqbox float-e-margins">
                        <div class="inqbox-content">
                            <div style="text-align: center">
                                <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                <ul id="error_message_box"></ul>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-xs-right">
                                    <?=ktranslate2("To");?>:
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="recipient" id="recipient" value="<?= $message_info->sender_name; ?>" />
                                    <input type="hidden" class="form-control" name="hid_recipient_id" id="hid_recipient_id" value="<?= $message_info->sender_id; ?>" />
                                    <input type="hidden" class="form-control" name="recipient_email" id="recipient_email" value="" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label text-xs-right">
                                    <?=ktranslate2("Subject");?>:
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="subject" id="subject" value="<?= ((trim($message_info->header) !== "") ? "RE: " . $message_info->header : "") ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label required text-xs-right">
                                    <?=ktranslate2("Message");?>:
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" style="height: 150px" name="message" id="message">
                                        <?= ((trim($message_info->body) !== "") ? "<br/><br/><br/>------<br/><div style='padding-left:20px;'><i style='font-size:12px;'>" . $message_info->sender_name . " wrote on " . date($this->config->item("date_format") . " H:iA", strtotime($message_info->send_date)) . "</i><br/><br/><div style='border-left:2px solid #ccc; padding-left:10px;'>" . $message_info->body . "</div></div>" : "") ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <?php if ($user_info->role_id == CUSTOMER_ROLE_ID):?>
                        <?php else:?>
                        <a href="<?=site_url('messages/inbox')?>" class="btn btn-default btn-secondary"><?= $this->lang->line("common_close"); ?></a>
                        <?php endif; ?>
                        <?php if ( $message_info->message_id > 0 ):?>
                        <button type="button" class="btn btn-danger" id="btn-delete-message" data-id="<?=$message_info->message_id;?>"><span class="fa fa-trash"></span> Delete message</button>
                        <?php endif; ?>
                        <?php
                        echo form_submit(
                                array(
                                    'name' => 'submit',
                                    'id' => 'submit',
                                    'value' => ktranslate2('Send'),
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

<?php
echo form_close();
?>

<?php $this->load->view("partial/footer"); ?>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function () {
        $('#message').summernote({height: 350});
        
        $("#btn-delete-message").click(function(){            
            var id = $(this).attr("data-id");
            var ids = [];
            ids.push(id);
            
            alertify.confirm("Are you sure you wish to delete this message?", function(){
                var url = '<?=site_url('messages/ajax')?>';
                var params = {
                    type:2,
                    ids:ids,
                    softtoken:$("input[name='softtoken']").val()
                };
                $.post(url, params, function(data){
                    if ( data.success )
                    {
                        window.location.href = '<?=site_url('messages/success?del=1')?>'
                    }
                }, "json");
            }).set({title:'Confirm'});
        });
        
        init_uploader();
        init_settings();

        $('#recipient').autocomplete({
            serviceUrl: '<?php echo site_url("employees/employee_search"); ?>',
            onSelect: function (suggestion) {
                $("#hid_recipient_id").val(suggestion.data);
                $("#recipient_email").val(suggestion.email);
            }
        });
    });

    function init_settings() {
        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
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
                recipient: "required",
                subject: "required",
                message: "required"
            },
            messages: {
                recipient: "Recipient is required!",
                subject: "Subject is required!",
                message: "Message is required!"
            }
        };

        $('#message_form').validate(settings);

        function post_message_form_submit(response) {
            if (response.success=='1')
            {
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = "<?=site_url("messages/success")?>";                    
                }, 1000);                
            } 
            else
            {
                set_feedback(response.message, 'error_message', true);
            }

            $("#message_form").attr("action", "<?= site_url(); ?>messages/save/" + response.message_id);
        }
    }

    function init_uploader() {
        // Uploader scripts
        var uploader_a = new plupload.Uploader({
            runtimes: 'html5,flash,silverlight,html4',
            browse_button: 'pickfiles_a', // you can pass in id...
            container: document.getElementById('container_a'), // ... or DOM Element itself
            url: $("#site_url").val() + 'messages/upload_attachment',
            unique_names: true,
            resize: {width: 500, height: 500, quality: 100},
            max_retries: 3,
            flash_swf_url: 'Moxie.swf',
            silverlight_xap_url: 'Moxie.xap',
            multipart_params: {
                message_id: '<?= $message_info->message_id; ?>',
                softtoken: $("#token_hash").val(),
                linker: $("#linker").val()
            },
            filters: {
                max_file_size: '10mb',
                mime_types: [
                    {title: "All files", extensions: "jpg,gif,png,xls,xlsx,csv,doc,docx,pdf"},
                ]
            },
            init: {
                FilesAdded: function (up, files) {
                    $(".progress").hide();
                    $(".progress-bar").width(0);
                    up.start();
                },
                UploadProgress: function (up, file) {
                    $(".progress").show();
                    $(".progress-bar").width(file.percent);
                },
                Error: function (up, err) {
                    console.log("\nError #" + err.code + ": " + err.message);
                }
            }
        });

        uploader_a.bind('FileUploaded', function (upldr, file, object) {
            var myData;
            try
            {
                myData = eval(object.response);
            } catch (err)
            {
                myData = eval('(' + object.response + ')');
            }

            $("#filelist_a").append("<li><a href=\"uploads/messages-" + myData.message_id + "/" + myData.filename + "\" target=\"_blank\" title=\"" + myData.filename + "\"><img src=\"" + myData.icon + "\" /></a><span class=\"close remove-file\" data-file-id=\"" + myData.id + "\" title=\"Remove this file\"><i class=\"fa fa-times-circle\"></i></span></li>");
        });

        uploader_a.init();
    }
</script>