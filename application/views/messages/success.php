<?php $this->load->view("partial/header"); ?>

<div class="section">
    <div class="row sameheight-container">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-block">
                    
                    <?php if ( isset($_GET['del']) && $_GET['del'] == '1' ):?>
                        <div class="alert alert-success" style="text-align:center"><h2>Your message has been deleted successfully!</h2></div>
                    <?php else: ?>
                        <div class="alert alert-success" style="text-align:center"><h2>Your message has been sent successfully!</h2></div>
                    <?php endif; ?>
                    
                    <div class="form-group" style="text-align: center">
                        <?php if ($user_info->role_id == CUSTOMER_ROLE_ID):?>
                            <a href="<?=site_url('leads/dashboard')?>" class="btn btn-default">Close</a>
                        <?php else: ?>
                            <a href="<?=site_url('messages/inbox')?>" class="btn btn-default">Close</a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>    
</div>

<?php $this->load->view("partial/footer"); ?>