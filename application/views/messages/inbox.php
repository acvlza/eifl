<?php $this->load->view("partial/header"); ?>

<style>
    #tbl_inbox td:nth-child(4) {
        text-align: center;
    }
    #tbl_inbox th:nth-child(2),
    #tbl_inbox td:nth-child(2) {
        width:250px;
        min-width:250px;
    }
    #tbl_inbox th:nth-child(4),
    #tbl_inbox td:nth-child(4) {
        width:250px;
        min-width:250px;
    }
    .dataTables_info {
        float:left;
    }
    
    #tbl_inbox_wrapper th:nth-child(1){
        width:46px;
        min-width:46px;
    }
</style>

<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>

<div class="title-block">
    <h3 class="title"><?=ktranslate2("Inbox");?></h3>
    <p class="title-description">
        <?=ktranslate2("Add, update & delete inbox");?>
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

                                <div class="inqbox-content table-responsive">

                                    <table class="table table-hover table-bordered" id="tbl_inbox">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 1%"></th>
						<th style="text-align: center"><?=ktranslate2("Sender Name");?></th>
                                                <th style="text-align: center"><?=ktranslate2("Subject");?></th>
                                                
                                                <th style="text-align: center"><?=ktranslate2("Date");?></th>                            
                                            </tr>
                                        </thead>
                                    </table>

                                    <?= $tbl_inbox; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo form_open('messages/ajax', 'id="frmMessageDelete"', ["type" => 2]); ?>
<?php echo form_close(); ?>

<script>
    $(document).ready(function () {
        $("#tbl_inbox_filter").prepend("<a href='<?= site_url('messages/view/-1') ?>' class='btn btn-primary pull-left'><?=ktranslate2("New Message");?></a>");
        $("#tbl_inbox_filter input[type='search']").attr("placeholder", "<?=ktranslate2("Type your search here");?>");
        $("#tbl_inbox_filter input[type='search']").removeClass("input-sm");

        $(document).on("click", ".btn-delete", function () {
            var $this = $(this);
            alertify.confirm("<?=ktranslate2("Are you sure you wish to delete this message?");?>", function () {
                var url = $("#frmMessageDelete").attr("action");
                var params = $("#frmMessageDelete").serialize();
                params += '&ids=' + $this.attr("data-message-id");
                $.post(url, params, function (data) {
                    if (data.success)
                    {
                        $("#tbl_inbox").DataTable().ajax.reload();
                    }
                }, "json");
            });
        });
    });
</script>

<?php $this->load->view("partial/footer"); ?>