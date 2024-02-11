<?php $this->load->view("partial/header"); ?>
<style>
    td:nth-child(5), 
    td:nth-child(6) {
        text-align: right
    }
    td:nth-child(2),
    td:nth-child(7), 
    td:nth-child(9) {
        white-space: nowrap;
        text-align: center;
    }
    
    .dataTables_scrollFootInner {
        width:100% !important;
    }
</style>

<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>

<div class="title-block">
    <h3 class="title"> 

        <?=ktranslate2("List of Payments")?>

    </h3>
    <p class="title-description">
        <?=ktranslate2("Add, update & delete payments")?>
    </p>
</div>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">
            <div class="card" style="width:100%">

                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inqbox float-e-margins">
                                <div class="inqbox-content">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><?=ktranslate2("Transaction Date From")?>:</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
                                                    <input type="text" class="form-control" id="filter_from_date" value="" autocomplete="new-value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label><?=ktranslate2("Transaction Date To")?>:</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
                                                    <input type="text" class="form-control" id="filter_to_date" value="" autocomplete="new-value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>&nbsp;<?=ktranslate2("Loan Status")?>:</label>
                                                <div>
                                                    <select class="form-control" id="filter_loan_status">
                                                        <option value=""><?=ktranslate2("All")?></option>
                                                        <option value="pending"><?=ktranslate2("Pending")?></option>
                                                        <option value="active"><?=ktranslate2("Active (Current)")?></option>
                                                        <option value="completed"><?=ktranslate2("Completed")?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <button type="button" class="btn btn-primary" id="btn-search"><?=ktranslate2("Search")?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>


<div class="section">
    <div class="row sameheight-container">

        <div class="col-lg-12">
            <div class="card" style="width:100%; min-height: calc(85vh - 160px);">

                <div class="card-block">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="inqbox float-e-margins">
                                <div class="inqbox-content table-responsive">

                                    <table id="tbl_payments" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 1%"></th>
                                                <th style="text-align: center"><?= $this->lang->line('common_trans_id') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('loans_customer') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('payments_loan') ?></th>
                                                <th style="text-align: center"><?= ktranslate2("Paid amount")?></th>
                                                <th style="text-align: center"><?= $this->lang->line('loans_balance') ?></th>                    
                                                <th style="text-align: center"><?= $this->lang->line('payments_date_paid') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('payments_teller') ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" style="text-align:right" class="tf-label"><?= ktranslate2("Total")?>:</th>
                                                <th colspan="1" style="text-align:right" class="tf-total-paid"></th>
                                                <th colspan="3"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                    <?=$tbl_payments; ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="extra-filters" style="display: none;">
    &nbsp;<button class="btn btn-primary" id="btn-export-pdf"><span class="fa fa-print"></span> <?=ktranslate2("Print")?></button>
    <select class="form-control input-sm hidden-xs" id="sel-staff">
        <option value="-1"><?=ktranslate2("All")?></option>
        <?php foreach ($staffs as $staff): ?>
            <option value="<?= $staff->person_id; ?>" <?= ((isset($_GET['employee_id'])) && $_GET['employee_id'] === $staff->person_id) ? 'selected="selected"' : ""; ?>><?= $staff->first_name . " " . $staff->last_name; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Modal -->
<div class="modal fade" id="md-payment-receipt" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line("common_print"); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <div class="modal-body">
                <div id="div_embed"><?=ktranslate2("Loading, please wait...")?></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close"><?=ktranslate2("Close")?></button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php echo form_open(); ?>
<?php echo form_close(); ?>

<div id="dt-extra-params">
    <input type="hidden" name="employee_id" id="employee_id" />
    <input type="hidden" id="from_date" name="from_date" value="" />
    <input type="hidden" id="to_date" name="to_date" value="" />
    <input type="hidden" id="loan_status" name="loan_status" value="" />
</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    function paymentsFooter( row, data, start, end, display, table )
    {
        var api = table.api(), data;
        var url = '<?=site_url('payments/ajax');?>';
        var params = {
            type: 4,
            softtoken:$("input[name='softtoken']").val()
        };
        $.post(url, params, function(data){
            if ( data.status == "OK" )
            {
                $( api.column( 4 ).footer() ).html(data.total_balance);
            }
        }, "json");
    }
    
    $(document).ready(function (){
        $("#sel-staff").select2('destroy'); 
        
        $(document).on("click", "#btn-export-pdf", function(){            
            var url = '<?=site_url('printing/payment_list/payment');?>';
            var params = {
                softtoken:$("input[name='softtoken']").val(),
                title: '<?=ktranslate2("Payment Transaction Report")?>',
                date_from:$("#filter_from_date").val(),
                date_to:$("#filter_to_date").val(),
                loan_status:$("#filter_loan_status").val(),
                keywords: $("#tbl_payments_filter input[type='search']").val()
            };
            blockElement("#btn-export-pdf");
            $.post(url, params, function(data){
                if ( data.status == "OK" )
                {
                    window.open(data.url,'_blank');
                }
                unblockElement("#btn-export-pdf");
            }, "json");
        });
        
        $('.input-group.date').datepicker({
            format: '<?= calendar_date_format(); ?>',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $("#btn-search").click(function () {
            $("#from_date").val($("#filter_from_date").val());
            $("#to_date").val($("#filter_to_date").val());
            $("#loan_status").val($("#filter_loan_status").val());
            $("#tbl_payments").DataTable().ajax.reload();
        });
        
        $("#tbl_payments_filter").prepend("<a href='<?= site_url('payments/view/-1') ?>' class='btn btn-primary pull-left'><?=ktranslate2("New payment")?></a>");
        $("#tbl_payments_filter input[type='search']").attr("placeholder", "<?=ktranslate2("Type your search here")?>");
        $("#tbl_payments_filter input[type='search']").removeClass("input-sm");
        $("#tbl_payments_filter").append($(".extra-filters").html());
        
        $(document).on("change", "#sel-staff", function(){
            $("#employee_id").val($(this).val());
            $("#tbl_payments").DataTable().ajax.reload();
        });
        
        $(document).on("click", ".btn-delete", function(){
            var $this = $(this);
            alertify.confirm("<?=ktranslate2("Are you sure you wish to delete this payment")?>?", function(){
                var url = '<?=site_url('payments/delete')?>';
                var params = {
                    softtoken: $("input[name='softtoken']").val(),
                    ids: [$this.data("payment-id")]
                };
                $.post(url, params, function(data){
                    if ( data.success )
                    {
                        $("#tbl_payments").DataTable().ajax.reload();
                    }
                }, "json");
            });
        });

        $(document).on("click", ".btn-print-receipt", function () {
            <?php if ( !$is_mobile ): ?>
                var url = $(this).attr("data-url");
                var params = {
                    softtoken: $("input[name='softtoken']").val()
                };
                $("#div_embed").html('<?=ktranslate2("Loading, please wait...")?>');
                $("#md-payment-receipt").modal("show");
                $.post(url, params, function (data) {
                    $("#div_embed").html(data);
                }, 'html');
            <?php else: ?>
                window.location.href = $(this).data("url");
            <?php endif; ?>
        });

        enable_delete('<?php echo $this->lang->line($controller_name . "_confirm_delete") ?>', '<?php echo $this->lang->line($controller_name . "_none_selected") ?>');

        $(".select_all_").click(function () {
            if ($(this).is(":checked"))
            {
                $("input[name='chk[]']").prop("checked", true);
            } else
            {
                $("input[name='chk[]']").prop("checked", false);
            }
        });

    });
</script>