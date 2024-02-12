<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <?php if ($this->config->item("app_logo") != '') : ?>
                    <div>
                        <img src="<?= base_url('uploads/app/' . $this->config->item("app_logo")) ?>" style="max-width: 75%;" />
                    </div>
                <?php else : ?>
                    <div class="logo">
                        <span class="l l1"></span>
                        <span class="l l2"></span>
                        <span class="l l3"></span>
                        <span class="l l4"></span>
                        <span class="l l5"></span>
                    </div> <a href="<?= site_url('home'); ?>" style="color:white;text-decoration: none;"> EIFL Lending</a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="menu">

            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li class="">
                    <a href="<?php echo site_url("home"); ?>" >
                        <span class="pl-3">Dashboard</span>
                        <i class="fa arrow"></i>
                    </a>
                    
                </li>
                <hr>
                <li style="color: rgba(255, 255, 255, 0.5); padding-left: 20px;   text-transform: uppercase;   font-weight: 700;"> Loan Management  </li>
                <hr>
                <li class="">
                    <a href="#" title="Module Description Here">
                        <span class="pl-3">Borrowers</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li>
                        <a href="<?php echo site_url("customers/view/-1"); ?>">
                                Add New Borrower
                            </a>
                        </li>
                        <li>
                        <a href="<?php echo site_url("customers/index"); ?>">
                                Borrowers List
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="#">
                    <a href="#">
                        <i class="fa arrow"></i><span class="pl-3">Loans</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="">
                        <a href="<?php echo site_url("loans/view/-1"); ?>">
                                Add New Loan
                            </a>
                        </li>
                        <li>
                        <a href="<?php echo site_url("loans/index"); ?>">
                                Loans List
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                <li style="color: rgba(255, 255, 255, 0.5); padding-left: 20px;   text-transform: uppercase;   font-weight: 700;"> Accounting  </li>
                <hr>
                <li class="">
                    <a href="<?php echo site_url("overdues"); ?>" title="Module Description Here">
                        <span class="nav-label">Receivables</span>
                        <i class="fa arrow"></i>
                    </a>
                    
                </li>


                <li class="#">
                    <a href="#" title="Module Description Here">
                        <span class="nav-label">Payments</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="">
                        <a href="<?php echo site_url("payments/view/-1"); ?>">
                                Add New Payment
                            </a>
                        </li>
                        <li>
                        <a href="<?php echo site_url("payments/index"); ?>">
                                Payment List
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                <li style="color: rgba(255, 255, 255, 0.5); padding-left: 20px;   text-transform: uppercase;   font-weight: 700;"> User & System Settings  </li>
                <hr>
                <li class="#">
                    <a href="#" title="Module Description Here">
                        <span class="nav-label">User & Roles</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li class="">
                        <a href="<?php echo site_url("employees/view/-1"); ?>">
                                New User
                            </a>
                        </li>
                        <li>
                        <a href="<?php echo site_url("employees/index"); ?>">
                                User List
                            </a>
                        </li>
                        <li class="">
                        <a href="<?php echo site_url("roles/view/-1"); ?>">
                                New Role
                            </a>
                        </li>
                        <li class="">
                        <a href="<?php echo site_url("roles/index"); ?>">
                                Roles List
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="">
                    <a href="<?php echo site_url("config"); ?>" title="Module Description Here">
                        <span class="nav-label">System</span>
                        <i class="fa arrow"></i>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo site_url("plugins"); ?>" title="Module Description Here">
                        <span class="nav-label">Plugins</span>
                        <i class="fa arrow"></i>
                    </a>
                </li>


                
            </ul>
        </nav>
    </div>
</aside>

<div class="nano left-sidebar">
    <div class="nano-content">
        <ul class="nav nav-pills nav-stacked nav-inq">

        </ul>
    </div>
</div>