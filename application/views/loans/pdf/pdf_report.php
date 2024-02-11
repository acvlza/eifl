<html>
    <head>
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>bootstrap3/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>font-awesome-4.3.0/css/font-awesome.min.css" />
        <style>
            ul.checkbox-grid li {
                display: block;
                float: left;
                width: 40%;
                text-decoration: none;
            }

            .loans_pdf_company_name, .loans_pdf_title{
                text-align: center;
            }
            #tbl-header td {
                padding:2px;
            }
			.company-name {
    color: #000096;
    font-weight: bold;
}
			
			

        </style>
    </head>
    <body>
        <div class="loans_pdf_company_name"> <h4 class="company-name"><?= $company_name; ?></h4>
			<hr style="background-color: #5a7a8e; height: 1px; border: none; margin-top: 0; margin-bottom: 0;">

            <h6 style="color:#5a7a8e">
                <?= $company_address; ?> |
                <?= ktranslate2("Tel. No. ") . $phone . " " . ktranslate2("Fax") . $fax . " " . ktranslate2("Email") . $email;?> 
            </h6>
			<hr style="background-color: #5a7a8e; height: 1px; border: none; margin-top: 0; margin-bottom: 0;">


        </div>

        <div class="loans_pdf_title">
			<br>
            <h4><?= $this->lang->line("loans_disclosure_title"); ?></h4>
			<br>
        </div>

        <table class="table" id="tbl-header" style="border-collapse: collapse; border: 1px solid #5a7a8e;">

            <tr>
                <td><b><?= $this->lang->line("common_full_name"); ?></b></td>
                <td colspan="3"><?= $customer_name; ?></td>
                <td style="width:110px"><b><?=ktranslate2("Transaction #");?>:</b></td>
                <td><?=$loan->loan_id;?></td>
            </tr>
            <tr>
                <td><b><?= $this->lang->line("common_address_present"); ?></b></td>
                <td colspan="5"><?= $customer_address; ?></td>
            </tr>
            <tr>
                <td><b><?= $this->lang->line("loans_type"); ?></b></td>
                <td><?= ucwords(str_replace("_", " ", $loan->interest_type)); ?></td>
                <td style="width:150px;"><b><?= $this->lang->line("loan_type_term"); ?></b></td>
                <td><?= $term . " " . ktranslate2($term_period); ?></td>
                <td><b><?=ktranslate2("Interest Rate")?></b></td>
                <td><?= $rate ?>%</td>
            </tr>
            <tr>
                <td><b><?= $this->lang->line("loans_apply_date"); ?></b></td>
                <td><?= date($this->config->item('date_format'), $loan->loan_applied_date); ?></td>
                <td><b><?= $this->lang->line("loans_payment_date"); ?></b></td>
                <td><?= date($this->config->item('date_format'), $loan->loan_payment_date); ?></td>
                <td><b><?= $this->lang->line("loan_type_penalty"); ?></b></td>
                <td>__</td>
            </tr>
        </table>

        <div>
            <label><?= strtoupper($this->lang->line("loan_type_payment_sched")); ?></label>
            <ul class="checkbox-grid">
                <?php foreach ($schedules as $key => $schedule): ?>
                    <?php if ($key === $term_period): ?>
                        <li>[x] <label for="text1"><?= $schedule; ?></label></li>
                    <?php else: ?>
                        <li>[ ] <label for="text1"><?= $schedule; ?></label></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <table class="table loans_pdf_loan_amount">
            <tr>
                <td><?= ktranslate2("PAYABLE AMOUNT")?>:</td>
                <td style="text-align: right"><?= $payable; ?></td>
            </tr>
            <tr>
                <td><strong><?= ktranslate2("APPLIED AMOUNT")?></strong></td>
                <td style="text-align: right"><?= $loan_amount; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $this->lang->line("loan_type_less_charge") ?>:</td>
            </tr>

            <?php foreach ($misc_fees as $misc_fee): ?>
                <tr>
                    <td><?= $misc_fee[0]; ?></td>
                    <td style="text-align: right"><?= $misc_fee[1]; ?></td>
                </tr>
            <?php endforeach; ?>
                
            <?php if ($loan->interest_type == 'loan_deduction'): ?>
            <tr>
                <td><?=ktranslate2("Loan Interest")?>:</td>
                <td style="text-align: right"><?=$loan_deduction_interest;?></td>
            </tr>
            <?php endif; ?>
                
            <tr>
                <td><?= strtoupper($this->lang->line("loan_type_total_deduction")) ?></td>
                <td style="text-align: right"><?= $total_deductions; ?></td>
            </tr>
            <tr>
                <td><?= strtoupper($this->lang->line("loan_type_net_proceed")) ?></td>
                <td style="text-align: right"><?= $net_loan; ?></td>
            </tr>
            
            <?php if ( count($add_fees) > 0 ): ?>
            <tr>
                <td><strong><?=ktranslate2("Additional Fees")?></strong></td>
            </tr>
            <?php endif ?>
            
            <?php foreach( $add_fees as $desc => $amount ): ?>
                <tr>
                    <td><?=$desc?></td>
                    <td style="text-align: right"><?= to_currency($amount); ?></td>
                </tr>
            <?php endforeach; ?>
            
        </table>
           

        <div>
            <?= strtoupper($this->lang->line("loan_type_acknowledgment")); ?>

            <table class="table">
                <tr>
                    <td style="height: 200px"><?= $this->lang->line("loan_type_prepared_by") ?>:</td>
                    <td>&nbsp;</td>
                    <td><?= $this->lang->line("loan_type_checked_by") ?>:</td>
                    <td>&nbsp;</td>
                    <td><?= $this->lang->line("loan_type_approved_by") ?>:</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?= $this->lang->line("loan_type_noted_by") ?>:</td>
                    <td>&nbsp;</td>
                    <td><?= $this->lang->line("loan_type_received_by") ?>:</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

    </body>

</html>