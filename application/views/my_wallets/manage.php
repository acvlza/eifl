<?php $this->load->view("partial/header"); ?>
<style>
    .dataTable th:nth-child(2),
    .dataTable td:nth-child(2) {
        width: 210px !important;
        min-width: 210px !important;
    }
    .dataTable th:nth-child(3),
    .dataTable td:nth-child(3) {
        width: 110px !important;
        min-width: 110px !important;
    }
    #tbl_wallets_wrapper td:nth-child(5),
    #tbl_wallets_wrapper td:nth-child(6)
    {
        text-align: center;
    }
    #tbl_wallets_wrapper td:nth-child(3)
    {
        text-align: right;
    }
</style>


<div class="title-block">
    <h3 class="title">
        <?= ktranslate2("My Wallet");?> (<span id="wallet_total"><?php echo to_currency($wallet_total); ?></span>)
        <input type="hidden" id="available_amount" value="<?= $wallet_total ?>" />
    </h3>
    <p class="title-description">

    </p>
</div>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">
            <div class="card" style="width:100%">
                <div class="card-block">
                    <div class="row" id="dt-extra-params">
                    
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label><?= ktranslate2("Trans. Date From");?>:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text" style="font-style: normal"><i class="fa fa-calendar"></i></span></span>
                                    <input type="text" class="form-control" name="trans_from_date" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label><?= ktranslate2("Trans. Date To");?>:</label>
                                <div class="input-group date">
                                    <span class="input-group-addon input-group-prepend"><span class="input-group-text" style="font-style: normal"><i class="fa fa-calendar"></i></span></span>
                                    <input type="text" class="form-control" name="trans_to_date" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-primary" id="btn-search"><?= ktranslate2("Search");?></button>
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
            <div class="card" style="width:100%">

                <div class="card-block">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="inqbox float-e-margins">
                                
                                <div class="inqbox-content table-responsive">

                                    <table id="tbl_wallets" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 1%"></th>
                                                <th style="text-align: center"><?= ktranslate2("Name"); ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('my_wallet_amount') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('my_wallet_description') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('my_wallet_type') ?></th>
                                                <th style="text-align: center"><?= $this->lang->line('my_wallet_trans_date') ?></th>                    
                                            </tr>
                                        </thead>
                                    </table>
                                    
                                    <?=$tbl_wallets; ?>

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
    &nbsp;<button class="btn btn-primary" id="btn-export-pdf"><span class="fa fa-print"></span> <?= ktranslate2("Print")?></button>
    <select class="form-control input-sm hidden-xs" id="sel-staff">
        <option value="0"><?= ktranslate2("Select staff")?></option>
        <?php foreach ($staffs as $staff): ?>
            <option value="<?= $staff->person_id; ?>" <?= ((isset($_GET['employee_id'])) && $_GET['employee_id'] === $staff->person_id) ? 'selected="selected"' : ""; ?>><?= $staff->first_name . " " . $staff->last_name; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<div id="table_action_header">
    <div class="row">
        <div class="col-xs-3">
            <?php echo anchor("$controller_name/delete", $this->lang->line("common_delete"), array('id' => 'delete-wallet', 'class' => 'btn btn-primary')); ?>
        </div>
        <div class="col-xs-9">
            <div class="pull-right">
                <select class="form-control" id="sel-staff">
                    <option value="0">Select staff</option>
                    <?php foreach ($staffs as $staff): ?>
                        <option value="<?= $staff->person_id; ?>" <?= ((isset($_GET['employee_id'])) && $_GET['employee_id'] === $staff->person_id) ? 'selected="selected"' : ""; ?>><?= $staff->first_name . " " . $staff->last_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php echo form_open();?>
<?php echo form_close();?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $(document).on("click", ".btn-edit-wallet", function(){
            var url = $(this).attr("data-href");
            var params = {
                softtoken:$("input[name='softtoken']").val()
            };
            $.post(url, params, function(data){
                $("#wallet_modal .modal-content").html(data);
                $("#wallet_modal").modal("show");
            });
        });
        
        $("#sel-staff").select2("destroy");
        
        $("#btn-search").click(function(){
            $("#tbl_wallets").DataTable().ajax.reload();
        });
        
        $("#tbl_wallets_filter").prepend("<a href='javascript:void(0)' data-href='<?= site_url('my_wallets/view/-1') ?>' class='btn btn-edit-wallet btn-primary pull-left'><?= ktranslate2("Add amount")?></a>");
        $("#tbl_wallets_filter input[type='search']").attr("placeholder", "<?= ktranslate2("Type your search here")?>");
        $("#tbl_wallets_filter input[type='search']").removeClass("input-sm");
        $("#tbl_wallets_filter").append($(".extra-filters").html());
        
        $(document).on("click", "#btn-export-pdf", function(){
            var clone = $("#tbl_wallets_wrapper .dataTables_scrollBody").clone();
            
            $(clone).find("table").attr("border", 1);
            $(clone).find("table").attr("cellpadding", 5);
            $(clone).find("table").attr("cellspacing", 1);
            $(clone).find("table").attr("width", "100%");
            $(clone).find("table th:nth-child(1)").remove();
            $(clone).find("table td:nth-child(1)").remove();
            
            var url = '<?=site_url('printing/print_list/my_wallet');?>';
            var params = {
                softtoken:$("input[name='softtoken']").val(),
                html: clone.html()
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
        
        $("#sel-staff").on("change", function () {
            location.href = "<?= site_url($this->uri->segment(1)) ?>?employee_id=" + $(this).val();
        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $(document).on("change", "#sel-staff", function () {
            location.href = "<?= site_url($this->uri->segment(1)) ?>?employee_id=" + $(this).val();
        });

        $(document).on("click", '.btn-delete', function (event) {
            var $this = $(this);
            
            alertify.confirm('<?php echo $this->lang->line("my_wallet_confirm_delete") ?>', function () {
                var url = '<?= site_url('my_wallets/ajax'); ?>';
                var params = {
                    ids: [$this.attr("data-wallet-id")], 
                    softtoken: $("input[name='softtoken']").val(),
                    type: 2
                };
                
                $.post(url, params, function (response)
                {
                    //delete was successful, remove checkbox rows
                    if (response.success)
                    {
                        $("#tbl_wallets").DataTable().ajax.reload();
                        
                        $("#wallet_total").html(response.wallet_amount);
                        $("#available_amount").val(response.wallet_total);
                        toastr.success(response.message);
                    } else
                    {
                        toastr.error(response.message);
                    }

                }, "json");
            });
        });

        $(".select_all_").click(function () {
            if ($(this).is(":checked"))
            {
                $(".select_").prop("checked", true);
            } else
            {
                $(".select_").prop("checked", false);
            }
        });

    });
</script>
