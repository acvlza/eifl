<?php $this->load->view("partial/header"); ?>
<script src="<?php echo base_url('js/documents.js?v=' . APP_VERSION) ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php echo form_open('loans/save/' . $loan_info->loan_id, array('id' => 'loan_form', 'class' => 'form-horizontal')); ?>

<style>
    #drop-target {
        border: 10px dashed #999;
        text-align: center;
        color: #999;
        font-size: 20px;
        width: 600px;
        height: 300px;
        line-height: 300px;
        cursor: pointer;
    }

    #drop-target.dragover {
        background: rgba(255, 255, 255, 0.4);
        border-color: green;
    }

    .kl-plugin {
        display: inline-block;
        padding: 2px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background-color: #f3e798;
    }

    .autocomplete-suggestions {
        overflow: auto;
    }

    ul#filelist li {
        display: inline;
        padding-left: 18px;
    }

    .collateral_docs img {
        width: 20px;
    }

    .collateral_docs div {
        display: inline-block;
        padding: 2px;
        padding-right: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 3px;
    }
</style>

<input type="hidden" id="loan_id" name="loan_id" value="<?= $loan_info->loan_id; ?>" />
<input type="hidden" id="controller" value="<?= strtolower($this->lang->line('module_' . $controller_name)); ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />

<div class="title-block">
    <h3 class="title">

        <?php if ($loan_info->loan_id > 0) : ?>
            <?= ktranslate2("Update Loan") ?>
        <?php else : ?>
            <?= ktranslate2("New Loan") ?>
        <?php endif; ?>

    </h3>
    <p class="title-description">
        <?= ktranslate2("Loan basic information") ?>
    </p>
</div>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-block">
                    <div class="inqbox float-e-margins">
                        <div class="inqbox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs nav-tabs-bordered">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-info"><?= $this->lang->line("loans_information"); ?></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sectionF"><?= ktranslate2("Loan Calculator") ?></a></li>
                                    <li class="nav-item"><a class="nav-link" href="#checks-section" data-toggle="tab">Checks</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-loan-deduction"><?= ktranslate2("Proceeds Deduction") ?></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-add-fees"><?= ktranslate2("Additional Fees") ?></a></li>
                                    <?php if ($loan_info->loan_id > 0) : ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-loan-documents"><?= ktranslate2("Documents") ?></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-collateral"><?= $this->lang->line('guarantee') ?></a></li>
                                        <?php if (is_plugin_active('notes')) : ?>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-notes"><?= ktranslate2('Notes') ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-info" class="tab-pane fade in active show">
                                        <div style="text-align: center">
                                            <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
                                            <ul id="error_message_box"></ul>
                                        </div>


                                        <?php
                                        if (is_plugin_active('loan_products')) {
                                            $this->load->view('loan_products/widgets/select', ["val" => $loan_info->loan_product_id]);
                                        }
                                        ?>


                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right">
                                                <?php echo form_label($this->lang->line('customers_customer') . ':', 'inp-customer', array('class' => 'wide required')); ?>
                                            </label>
                                            <div class="col-sm-10">
                                                <?php
                                                echo form_input(
                                                    array(
                                                        'name' => 'inp-customer',
                                                        'id' => 'inp-customer',
                                                        'type' => 'search',
                                                        'value' => $loan_info->customer_name,
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'nope',
                                                        'placeholder' => $this->lang->line('common_start_typing'),
                                                        'style' => 'display:' . ($loan_info->customer_id <= 0 ? "" : "none")
                                                    )
                                                );
                                                ?>

                                                <span id="sp-customer" style="display: <?= ($loan_info->customer_id > 0 ? "" : "none") ?>">
                                                    <?= $loan_info->customer_name; ?>
                                                    <span><a href="javascript:void(0)" title="Remove Customer" class="btn-remove-row"><i class="fa fa-times"></i></a></span>
                                                </span>
                                                <input type="hidden" id="customer" name="customer" value="<?= $loan_info->customer_id; ?>" />

                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right"><?php echo form_label($this->lang->line('loans_account') . ':', 'account', array('class' => 'wide required')); ?></label>
                                            <div class="col-sm-10">
                                                <?php
                                                echo form_input(
                                                    array(
                                                        'name' => 'account',
                                                        'id' => 'account',
                                                        'value' => $loan_info->account,
                                                        'class' => 'form-control'
                                                    )
                                                );
                                                ?>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right"><?php echo form_label($this->lang->line('loans_description') . ':', 'description', array('class' => 'wide')); ?></label>
                                            <div class="col-sm-10">
                                                <?php
                                                echo form_textarea(
                                                    array(
                                                        'name' => 'description',
                                                        'id' => 'description',
                                                        'value' => $loan_info->description,
                                                        'rows' => '5',
                                                        'cols' => '17',
                                                        'class' => 'form-control'
                                                    )
                                                );
                                                ?>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group row" id="data_1">
                                            <label class="control-label col-sm-2 text-xs-right">
                                                <?= ktranslate2("Apply Date") ?>:
                                            </label>
                                            <div class="col-sm-10">
                                                <div style="position:relative">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                        </span>
                                                        <?php
                                                        echo form_input(
                                                            array(
                                                                'name' => 'apply_date',
                                                                'id' => 'apply_date',
                                                                'value' => (isset($loan_info->loan_applied_date) && $loan_info->loan_applied_date > 0) ? date($this->config->item('date_format'), $loan_info->loan_applied_date) : date($this->config->item('date_format')),
                                                                'class' => 'form-control',
                                                                'type' => 'datetime',
                                                            )
                                                        );
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right"><?php echo form_label($this->lang->line('loans_agent') . ':', 'agent', array('class' => 'wide')); ?></label>
                                            <div class="col-sm-10">
                                                <?php if (strpos($role_info->name, 'admin') !== false) : ?>
                                                    <?php echo form_dropdown("sel_agent", $employees, ($loan_info->loan_agent_id > 0 ? $loan_info->loan_agent_id : $user_info->person_id), "id='sel_agent' class='form-control'"); ?>
                                                <?php else : ?>
                                                    <?= ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                                                <?php endif; ?>

                                                <input type="hidden" id="agent" name="agent" value="<?= ($loan_info->loan_agent_id > 0 ? $loan_info->loan_agent_id : $user_info->person_id) ?>" />
                                                <input type="hidden" id="approver" name="approver" value="<?= $loan_info->loan_approved_by_id; ?>" />
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right"><?php echo form_label($this->lang->line('loans_status') . ':', 'status', array('class' => 'wide')); ?></label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="status" name="status">
                                                    <option value="pending" <?= strtolower($loan_info->loan_status) == 'pending' ? 'selected="selected"' : ''; ?>><?= ktranslate2("Pending") ?></option>
                                                    <option value="paid" <?= strtolower($loan_info->loan_status) == 'paid' ? 'selected="selected"' : ''; ?>><?= ktranslate2("Paid") ?></option>
                                                    <option value="reject" <?= strtolower($loan_info->loan_status) == 'reject' ? 'selected="selected"' : ''; ?>><?= ktranslate2("Reject") ?></option>

                                                    <?php if (is_plugin_active('roles')) : ?>
                                                        <?php if ($role_info->approve_loan) : ?>
                                                            <option value="approved" <?= strtolower($loan_info->loan_status) == 'approved' ? 'selected="selected"' : ''; ?>><?= ktranslate2("Approved") ?></option>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <option value="approved" <?= strtolower($loan_info->loan_status) == 'approved' ? 'selected="selected"' : ''; ?>><?= ktranslate2("Approved") ?></option>
                                                    <?php endif; ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="control-label col-sm-2 text-xs-right"><?php echo form_label($this->lang->line('loans_remarks') . ':', 'remarks', array('class' => 'wide')); ?></label>
                                            <div class="col-sm-10">
                                                <?php
                                                echo form_textarea(
                                                    array(
                                                        'name' => 'remarks',
                                                        'id' => 'remarks',
                                                        'value' => $loan_info->remarks,
                                                        'rows' => '5',
                                                        'cols' => '17',
                                                        'class' => 'form-control'
                                                    )
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab-loan-deduction" class="tab-pane fade">

                                        <table class="table table-bordered" id="tbl-income-sources">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 1%">
                                                        <input type="checkbox" class="select_all_" />
                                                    </th>
                                                    <th style="text-align: center; width: 80%"><?= ktranslate2("Description") ?></th>
                                                    <th style="text-align: center; width: 20%"><?= ktranslate2("Amount") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($misc_fees as $misc_fee) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="select_" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="fees[]" value="<?= $misc_fee[0]; ?>" />
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" step="any" name="amounts[]" value="<?= $misc_fee[1]; ?>" />
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-primary" type="button" id="btn-add-row"><?= $this->lang->line("common_add_row"); ?></button>
                                        <button class="btn btn-danger" type="button" id="btn-del-row"><?= $this->lang->line("common_delete_row"); ?></button>
                                    </div>

                                    <div id="tab-add-fees" class="tab-pane fade">

                                        <table class="table table-bordered" id="tbl-add-fees">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 1%">
                                                        <input type="checkbox" class="select_all_fee_" />
                                                    </th>
                                                    <th style="text-align: center; width: 80%"><?= ktranslate2("Description") ?></th>
                                                    <th style="text-align: center; width: 20%"><?= ktranslate2("Amount") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($add_fees as $add_fee) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="select_fee_" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="add_fees[]" value="<?= $add_fee[0]; ?>" />
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" step="any" name="add_fee_amounts[]" value="<?= $add_fee[1]; ?>" />
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-primary" type="button" id="btn-add-row-fee"><?= $this->lang->line("common_add_row"); ?></button>
                                        <button class="btn btn-danger" type="button" id="btn-del-row-fee"><?= $this->lang->line("common_delete_row"); ?></button>
                                    </div>

                                    <div id="tab-loan-documents" class="tab-pane fade">
                                        <div id="div-documents">
                                            <button class="btn btn-primary tbl_documents_dt-custom-button" type="button" id="btn-upload-doc"><?= ktranslate2("Upload") ?></button>
                                            <table class="table table-hover table-bordered" id="tbl_documents">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; width: 1%"></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Document Name") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Description") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Modified Date") ?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <?= $tbl_documents; ?>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $("a[href='#tab-loan-documents']").click(function() {
                                                    $("#tbl_documents").DataTable().ajax.reload();
                                                });
                                            });
                                        </script>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div id="tab-collateral" class="tab-pane fade in">
                                        <div id="div-collateral">
                                            <button class="btn btn-primary tbl_collateral_dt-custom-button" data-id="" type="button" id="btn-add-collateral"><?= ktranslate2("Add") ?></button>
                                            <table class="table table-hover table-bordered" id="tbl_collateral">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; width: 1%"></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Name") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Type") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Model") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Make") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Serial #") ?></th>
                                                        <th style="text-align: center;"><?= ktranslate2("Est. Price") ?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <?= $tbl_collateral; ?>
                                        </div>
                                        <script>
                                            function load_collateral_info(id) {
                                                $("a[href='#tab-collateral-info']").parent().addClass("active");
                                                $("a[href='#tab-collateral-info']").addClass("active");
                                                $("#tab-collateral-info").addClass("active show");

                                                $("a[href='#tab-collateral-docs']").removeClass("active");
                                                $("#tab-collateral-docs").removeClass("active");

                                                if (id > 0) {
                                                    $("a[href='#tab-collateral-docs']").show();
                                                } else {
                                                    $("a[href='#tab-collateral-docs']").hide();
                                                }

                                                var url = '<?= site_url('loans/ajax') ?>';
                                                var params = {
                                                    ajax_type: 12,
                                                    id: id,
                                                    softtoken: $("input[name='softtoken']").val()
                                                };
                                                $.post(url, params, function(data) {
                                                    if (data.status == "OK") {
                                                        $("#md-upload-collateral-document input[name='doc_collateral[id]']").val(data.info.guarantee_id);

                                                        $("#md-collateral input[name='collateral[id]']").val(data.info.guarantee_id);
                                                        $("#md-collateral input[name='collateral[name]']").val(data.info.name);
                                                        $("#md-collateral input[name='collateral[type]']").val(data.info.type);
                                                        $("#md-collateral input[name='collateral[brand]']").val(data.info.brand);
                                                        $("#md-collateral input[name='collateral[make]']").val(data.info.make);
                                                        $("#md-collateral input[name='collateral[serial]']").val(data.info.serial);
                                                        $("#md-collateral input[name='collateral[price]']").val(data.info.price);
                                                        $("#md-collateral input[name='collateral[observations]']").val(data.info.observations);

                                                        load_collateral_doc_list();

                                                        $("#md-collateral").modal("show");
                                                    }
                                                }, "json");
                                            }

                                            $(document).ready(function() {
                                                $("a[href='#tab-collateral']").click(function() {
                                                    $("#tbl_collateral").DataTable().ajax.reload();
                                                });
                                                $(document).on("click", ".btn-edit-collateral, #btn-add-collateral", function() {
                                                    var id = $(this).attr("data-id");
                                                    load_collateral_info(id);
                                                });
                                                $(document).on("click", ".btn-delete-collateral", function() {
                                                    var id = $(this).attr("data-id");
                                                    alertify.confirm("<?= ktranslate2("Are you sure you wish to delete this data?") ?>", function() {
                                                        var url = '<?= site_url('loans/ajax') ?>';
                                                        var params = {
                                                            ajax_type: 13,
                                                            id: id,
                                                            softtoken: $("input[name='softtoken']").val()
                                                        };
                                                        $.post(url, params, function(data) {
                                                            if (data.status == "OK") {
                                                                $("#tbl_collateral").DataTable().ajax.reload();
                                                            }
                                                        }, "json");
                                                    });
                                                });
                                            });
                                        </script>
                                        <div class="clearfix"></div>
                                    </div>


                                    <div id="sectionF" class="tab-pane fade in">
                                        <?php $this->load->view('loans/tabs/calculator'); ?>
                                    </div>
                                    <div class="tab-pane" id="checks-section">
                                        <div id="div-checks">
                                            <!-- Button trigger modal -->
                                            <button class="btn btn-primary" type="button" id="btn-add-check" data-toggle="modal" data-target="#addCheckModal">
                                                <?= ktranslate2("Add Check") ?>
                                            </button>
                                        </div>
                                    </div>

                                    <?php if (is_plugin_active('notes')) : ?>
                                        <div id="tab-notes" class="tab-pane fade">
                                            <?php $this->load->view('notes/main') ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-lg-12">
                    <div class="form-group">

                        <a class="btn btn-default btn-secondary" id="btn-close" href="<?= site_url("loans"); ?>"><?= $this->lang->line("common_close"); ?></a>

                        <?php if ($user_info->can_approve_loan) : ?>
                            <button id="btn-approve" class="btn btn-success" type="button"><?= $this->lang->line('loans_approve'); ?></button>
                        <?php endif; ?>


                        <?php if ($loan_info->loan_id > 0) : ?>
                            <a href="<?= site_url("loans/" . ($loan_info->loan_type_id > 0 ? "generate_breakdown" : "fix_breakdown") . "/$loan_info->loan_id"); ?>" target="_blank" id="btn-sched" class="btn btn-warning"><?= $this->lang->line('loans_breakdown'); ?></a>
                            <a href="<?= site_url("loans/print_disclosure/$loan_info->loan_id"); ?>" target="_blank" id="btn-break-gen" class="btn btn-primary" type="button"><?= $this->lang->line('loans_disclosure'); ?></a>
                        <?php endif; ?>

                        <?php if (check_access($user_info->role_id, "loans", 'edit')) : ?>
                            <button id="btn-edit" class="btn btn-danger" type="button"><?= $this->lang->line('common_edit'); ?></button>
                        <?php endif; ?>

                        <?php if (check_access($user_info->role_id, "loans", 'add')) : ?>
                            <?php
                            echo form_submit(
                                array(
                                    'name' => 'submit',
                                    'id' => 'btn-save',
                                    'value' => $this->lang->line('common_save'),
                                    'class' => 'btn btn-primary'
                                )
                            );
                            ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

<!-- Modal -->
<div class="modal fade" id="md-collateral" role="dialog">
    <div class="modal-dialog" style="width: 70%;max-width: none;">
        <div class="modal-content">
            <div class="modal-header">
                <?= ktranslate2("Collateral - Details") ?>
            </div>
            <div class="modal-body" id="div-collateral-inputs">

                <div class="tabs-container">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-collateral-info"><?= ktranslate2("Info"); ?></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-collateral-docs"><?= ktranslate2("Documents") ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-collateral-info" class="tab-pane active fade in show">
                            <input type="hidden" name="collateral[id]" value="" />

                            <div class="col-lg-6" style="float:left">
                                <div class="form-group">
                                    <label><?= ktranslate2("Name") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[name]" />
                                </div>
                                <div class="form-group">
                                    <label><?= ktranslate2("Type") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[type]" />
                                </div>
                                <div class="form-group">
                                    <label><?= ktranslate2("Model") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[brand]" />
                                </div>
                            </div>
                            <div class="col-lg-6" style="float:left">
                                <div class="form-group">
                                    <label><?= ktranslate2("Make") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[make]" />
                                </div>
                                <div class="form-group">
                                    <label><?= ktranslate2("Serial") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[serial]" />
                                </div>
                                <div class="form-group">
                                    <label><?= ktranslate2("Est. Price") ?>:</label>
                                    <input type="text" class="form-control" name="collateral[price]" />
                                </div>
                            </div>

                            <div style="clear:both"></div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><?= ktranslate2("Observations") ?>:</label>
                                    <textarea class="form-control" name="collateral[observations]" style="height:250px;"></textarea>
                                </div>
                            </div>

                            <div style="clear:both"></div>

                        </div>
                        <div id="tab-collateral-docs" class="tab-pane fade in">
                            <div id="div-collateral-doc"></div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>

                <div style="clear:both"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ktranslate2("Close") ?></button>
                <button type="button" class="btn btn-primary" id="btn-save-collateral"><span class="fa fa-floppy-o"></span> <?= ktranslate2("Save changes"); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="md-upload-document" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= ktranslate2("Upload Document") ?>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart(site_url('loans/upload'), ["id" => "frmDocUpload"]); ?>
                <input type="hidden" name="loan_id" value="<?= $loan_info->loan_id; ?>" />
                <div class="form-group">
                    <input type="file" name="file" />
                </div>
                <div class="form-group">
                    <label><?= ktranslate2("Document Name") ?></label>
                    <input type="text" class="form-control" id="document_name" name="document_name" />
                </div>
                <div class="form-group">
                    <label><?= ktranslate2("Description") ?></label>
                    <textarea class="form-control" id="descriptions" name="descriptions"></textarea>
                </div>
                <?php echo form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ktranslate2("Close") ?></button>
                <button type="button" class="btn btn-primary" id="btn-submit-upload"><?= ktranslate2("Upload") ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="md-upload-collateral-document" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <?= ktranslate2("Upload Document") ?>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart(site_url('loans/upload_collateral'), ["id" => "frmCollateralDocUpload"]); ?>
                <input type="hidden" name="loan_id" value="<?= $loan_info->loan_id; ?>" />
                <input type="hidden" name="doc_collateral[id]" value="" />
                <div class="form-group">
                    <input type="file" name="doc_collateral[file]" />
                </div>
                <div class="form-group">
                    <label><?= ktranslate2("Document Name") ?></label>
                    <input type="text" class="form-control" id="doc_collateral_name" name="doc_collateral[document_name]" />
                </div>
                <div class="form-group">
                    <label><?= ktranslate2("Description") ?></label>
                    <textarea class="form-control" id="doc_collateral_descriptions" name="doc_collateral[descriptions]"></textarea>
                </div>
                <?php echo form_close(); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ktranslate2("Close") ?></button>
                <button type="button" class="btn btn-primary" id="btn-submit-upload-collateral"><?= ktranslate2("Upload") ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="addCheckModal" tabindex="-1" role="dialog" aria-labelledby="addCheckModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCheckModalLabel"><?= ktranslate2("Add Check") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('loans/save_check', array('id' => 'check_form')); ?>
                <!-- Check Type -->
                <div class="form-group">
                    <label for="check_type">Check Type</label>
                    <select class="form-control" id="check_type" name="check_type" required>
                        <option value="New Check">New Check</option>
                        <option value="Replacement Check">Replacement Check</option>
                    </select>
                </div>

                <!-- Bank Name -->
                <div class="form-group">
                    <label for="bank_name"><?= ktranslate2("Bank Name") ?></label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                </div>

                <!-- Check Number -->
                <div class="form-group">
                    <label for="check_number"><?= ktranslate2("Check Number") ?></label>
                    <input type="text" class="form-control" id="check_number" name="check_number" required>
                </div>

                <!-- Check Date -->
                <div class="form-group">
                    <label for="check_date"><?= ktranslate2("Check Date") ?></label>
                    <input type="date" class="form-control" id="check_date" name="check_date" required>
                </div>

                <!-- Amount -->
                <div class="form-group">
                    <label for="amount"><?= ktranslate2("Amount") ?></label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status"><?= ktranslate2("Status") ?></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value=""><?= ktranslate2("Select Status") ?></option>
                        <option value="cleared"><?= ktranslate2("Cleared") ?></option>
                        <option value="pending"><?= ktranslate2("Pending") ?></option>
                        <option value="cancelled"><?= ktranslate2("Cancelled") ?></option>
                        <option value="cancelled"><?= ktranslate2("Bounced") ?></option>
                        <option value="cancelled"><?= ktranslate2("Replaced") ?></option>
                        <!-- Add other statuses as necessary -->
                    </select>
                </div>


                <?php echo form_close(); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ktranslate2("Close") ?></button>
                <button type="button" class="btn btn-primary" id="save-check"><?= ktranslate2("Save Check") ?></button>
            </div>
        </div>
    </div>
</div>


<?php if (is_plugin_active('notes')) : ?>
    <?php $this->load->view('notes/form') ?>
<?php endif; ?>

<?php $this->load->view("partial/footer"); ?>

<input type="hidden" id="hid_account_check" name="hid_account_check" value="<?= $loan_info->customer_id ?>" />

<script src="<?php echo base_url(); ?>js/loan.js?v=<?= time(); ?>"></script>

<script>
    $("#btn-submit-upload-collateral").on("click", function() {
        $("#frmCollateralDocUpload").submit();
    });

    $(document).on("click", ".btn-delete-collateral-doc", function() {
        var $this = $(this);
        alertify.confirm("<?= ktranslate2("Are you sure you wish to delete this document") ?>?", function() {
            var url = SITE_URL + 'documents/ajax';
            var params = {
                softtoken: $("input[name='softtoken']").val(),
                type: 1,
                id: $this.attr("data-document-id")
            };
            $.post(url, params, function(data) {
                if (data.status == "OK") {
                    $("#tbl_doc_list").DataTable().ajax.reload();
                }
            }, "json");
        });
    });

    $("input[name='doc_collateral[file]']").on("change", function() {
        $("#doc_collateral_name").val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

    $("#frmCollateralDocUpload").on("submit", function(e) {
        e.preventDefault();
        var $this = $(this);
        var formData = new FormData(this);

        $("#btn-submit-upload-collateral").prop("disabled", true);
        $.ajax({
            url: $this.attr("action"),
            type: 'POST',
            data: formData,
            success: function(data) {
                var data = $.parseJSON(data);
                if (data.status == "OK") {
                    $("#md-upload-collateral-document").modal("hide");
                    $("#tbl_doc_list").DataTable().ajax.reload();
                } else {
                    alertify.alert("<?= ktranslate2("File extension is not allowed") ?>!");
                }

                $("#btn-submit-upload-collateral").prop("disabled", false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>

<script type='text/javascript'>
    function compute_additional_fees() {
        var total_add_fees = 0;
        $("input[name='add_fee_amounts[]']").each(function() {
            if (!isNaN(parseFloat($(this).val()))) {
                total_add_fees += parseFloat($(this).val());
            }
        });
        $("#sp-total-additional-fees").html(total_add_fees.toFixed(2));
        $("#hid_total_additiona_fees").val(total_add_fees);
    }

    //validation and submit handling
    $(document).ready(function() {
        $('.input-group.date').datepicker({
            format: '<?= calendar_date_format(); ?>',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $("#btn-save-collateral").click(function() {
            var url = '<?= site_url('loans/ajax') ?>';
            var params = $("#div-collateral-inputs input, #div-collateral-inputs select, #div-collateral-inputs textarea").serialize();
            params += '&ajax_type=11';
            params += '&softtoken=' + $("input[name='softtoken']").val();
            params += '&loan_id=<?= $loan_info->loan_id; ?>';
            $.post(url, params, function(data) {
                if (data.status == "OK") {
                    $("#md-collateral").modal("hide");
                    $("#tbl_collateral").DataTable().ajax.reload();
                }
            }, "json");
        });

        $("#btn-add-documents").click(function() {
            var document_ids = [];
            $("._select_doc").each(function() {
                if ($(this).is(":checked")) {
                    document_ids.push($(this).val());
                }
            });

            var url = '<?= site_url('loans/ajax') ?>';
            var params = {
                ajax_type: 8,
                loan_id: '<?= $loan_info->loan_id ?>',
                doc_type: $("#hid-collateral-doc-type").val(), // norman
                document_ids: document_ids,
                softtoken: $("input[name='softtoken']").val()
            };
            $.post(url, params, function(data) {
                if (data.status == "OK") {
                    $("#md-doc-list").modal("hide");
                    switch ($("#hid-collateral-doc-type").val()) {
                        case 'proof':
                            $("#div-proof-container").html(data.html);
                            break;
                        case 'images':
                            $("#div-docs-container").html(data.html);
                            break;
                    }
                }
            }, "json");
        });

        $(document).on("click", "#btn-upload-collateral-doc", function() {
            $("input[type='file']").val("");
            $("#doc_collateral_name").val("");
            $("#doc_collateral_descriptions").val("");
            $("#md-upload-collateral-document").modal("show");
        });

        $(document).on("click", "#btn-upload-doc", function() {
            $("input[type='file']").val("");
            $("#document_name").val("");
            $("#descriptions").val("");
            $("#md-upload-document").modal("show");
        });

        $(document).on("change, keyup", "#amount", function() {
            $("#sp-current-balance").html($(this).val());
            $("#current_balance").val($(this).val());
        });

        $(document).on("click", ".remove-file", function() {
            var el = $(this);
            $.ajax({
                url: '<?= site_url('loans/remove_file'); ?>',
                data: {
                    file_id: el.data("file-id"),
                    softtoken: $("input[name='softtoken']").val()
                },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $("input[name='softtoken']").val(data.token_hash);
                    el.parent().remove();
                },
                error: function() {
                    ;
                }
            });
        });

        $("#btn-add-row").click(function() {
            $(".select_all_").prop("checked", false);

            var rowCount = $('#tbl-misc-fees tr').length;
            if (rowCount > 1) {
                $("#tbl-income-sources tbody").append("<tr>" + $('#tbl-income-sources tr:last').html() + "</tr>");
            } else {
                $("#tbl-income-sources tbody").append("<tr><td><input type='checkbox' class='select_' /></td><td><input type='text' class='form-control' name='fees[]' /></td><td><input type='number' class='form-control' name='amounts[]' /></td></tr>");
            }
        });

        $(document).on("blur", "input[name='add_fee_amounts[]']", function() {
            compute_additional_fees();
        });

        $("#btn-add-row-fee").click(function() {
            $(".select_all_fee_").prop("checked", false);

            var rowCount = $('#tbl-add-fees tr').length;
            if (rowCount > 1) {
                $("#tbl-add-fees tbody").append("<tr>" + $('#tbl-add-fees tr:last').html() + "</tr>");
            } else {
                $("#tbl-add-fees tbody").append("<tr><td><input type='checkbox' class='select_fee_' /></td><td><input type='text' class='form-control' name='add_fees[]' /></td><td><input type='number' class='form-control' name='add_fee_amounts[]' /></td></tr>");
            }
        });

        $("#btn-del-row-fee").click(function() {
            $('.select_fee_').each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().remove();
                }
            });
        });

        $("#btn-del-row").click(function() {
            $('.select_').each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().remove();
                }
            });
        });

        $("#loan_type").change(function() {
            $("#loan_type_id").val($(this).val());
        });

        $("#sel_agent").change(function() {
            $("#agent").val($(this).val());
        });

        $("#btn-approve").click(function() {
            alertify.confirm("<?= ktranslate2('Are you sure you wish to approve this loan?') ?>", function() {
                var url = '<?= site_url('loans/ajax') ?>';
                var params = {
                    ajax_type: 2,
                    approver: '<?= $user_info->person_id; ?>',
                    loan_id: '<?= $loan_info->loan_id; ?>',
                    softtoken: $("input[name='softtoken']").val()
                };
                $.post(url, params, function(data) {
                    if (data.status == "OK") {
                        window.location.reload();
                    };
                }, 'json');
            });
        });

        if ($("#agent").val() <= 0) {
            $("#agent").val('<?= $user_info->person_id; ?>');
        }

        if ($("#loan_id").val() > -1) {
            $(".btn-remove-row").hide();
            $(".remove-file").hide();
            $("#loan_form input, #loan_form textarea").prop("readonly", true);
            $("#loan_form input[type='hidden']").prop("readonly", false);
            $("#loan_form select").prop("disabled", true);
            $("#btn-add-row").prop("disabled", true);
            $("#btn-del-row").prop("disabled", true);
            $("#btn-save").hide();

            if ($("#status").val() !== "approved") {
                $("#btn-approve").show();
            } else {
                $("#btn-approve").hide();
            }

            $("#btn-break-gen").show();
            $("#btn-edit").show();

            $("#btn-edit").click(function() {
                $("#btn-save").show();
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#loan_form input, textarea").prop("readonly", false);
                $("#loan_form select").prop("disabled", false);
                $("#btn-add-row").prop("disabled", false);
                $("#btn-del-row").prop("disabled", false);
                $("#btn-save").show();
            });
        } else {
            $("#btn-approve").hide();
            $("#btn-break-gen").hide();
            $("#btn-edit").hide();
        }

        $(document).on("click", ".btn-remove-row", function() {
            $("#sp-customer").hide();
            $("#sp-customer").html("");
            $("#inp-customer").val("");
            $("#inp-customer").show();
            $("#customer").val("");
        });

        $('#inp-customer').autocomplete({
            serviceUrl: '<?php echo site_url("loans/customer_search"); ?>',
            onSelect: function(suggestion) {
                $("#account").val(suggestion.data);
                $("#hid_account_check").val(suggestion.data);
                $("#customer").val(suggestion.data);
                $("#sp-customer").html(suggestion.value + ' <span><a href="javascript:void(0)" title="<?= ktranslate2("Remove Customer") ?>" class="btn-remove-row"><i class="fa fa-times"></i></a></span>');
                $("#sp-customer").show();
                $("#inp-customer").hide();
            }
        });

        validate = function(form) {
            if ($("#inp-customer").val() == '') {
                set_feedback("<?= ktranslate2('Please select a borrower') ?>", 'error_message');
                return false;
            }

            if ($("#account").val() == '') {
                set_feedback("<?= ktranslate2('Please eneter a valid Account#') ?>", 'error_message');
                return false;
            }

            if ($("#amount").val() == '') {
                set_feedback("<?= ktranslate2('Please calculate the applied amount from Loan calculator tab') ?>", 'error_message');
                return false;
            }

            if ($("#hid_account_check").val() == '') {
                set_feedback("<?= ktranslate2('The borrower you selected is not found in the borrower records. Please add this borrower from the borrowers section') ?>", 'error_message');
                return false;
            }

            return true;
        };

        $('#loan_form').submit(function(e) {
            e.preventDefault();

            if (!validate($(this))) {
                return;
            }

            $.post($(this).attr("action"), $(this).serialize(), function(data) {
                if (!data.success) {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);
                    window.location.href = '<?= site_url('loans/view/') ?>' + data.loan_id;
                }
            }, "json");
        });

        $("#btn-add-row-payment").click(function() {
            $(".payment_select_all_").prop("checked", false);

            var rowCount = $('#tbl-payment-sched tr').length;
            if (rowCount > 1) {
                $("#tbl-payment-sched tbody").append("<tr>" + $('#tbl-payment-sched tr:last').html() + "</tr>");
            } else {
                $("#tbl-payment-sched tbody").append("<tr><td><input type='checkbox' class='payment_select_' /></td><td><input type='date' class='form-control' name='payment_date[]' /></td><td><input type='number' class='form-control' name='payment_balance[]' /></td><td><input type='number' class='form-control' name='payment_interest[]' /></td><td><input type='number' class='form-control' name='payment_amount[]' /></td></tr>");
            }

            $('.input-group.date').datepicker({
                format: '<?= calendar_date_format(); ?>',
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        });

        $("#btn-del-row-payment").click(function() {
            $('.payment_select_').each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().remove();
                }
            });
        });

        $(".no-select2").select2("destroy");
    });

    function load_collateral_doc_list() {
        var url = '<?= site_url('loans/ajax') ?>';
        var params = {
            ajax_type: 14,
            id: $("input[name='collateral[id]']").val(),
            softtoken: $("input[name='softtoken']").val()
        };
        $.post(url, params, function(data) {
            $("#div-collateral-doc").html(data);
        });
    }

    $(document).ready(function() {
        $('#save-check').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = $('#check_form').serialize(); // Serialize the form data

            // Include CSRF token if it's enabled in CI config
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
            formData += '&' + csrfName + '=' + csrfHash;

            $.ajax({
                url: '<?= site_url("loans/save_check") ?>', // URL to your save_check method
                type: 'POST',
                dataType: 'json', // Expecting JSON response
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message); // Or handle more gracefully
                        $('#addCheckModal').modal('hide'); // Close the modal
                        // Optionally: refresh the list of checks or reset the form
                    } else {
                        // Show error message
                        alert(response.message); // Or display in the modal
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any AJAX errors
                    alert('AJAX error: ' + textStatus);
                }
            });
        });
    });
</script>