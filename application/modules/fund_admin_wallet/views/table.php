<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Hospital Details</h2>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                            class="zmdi zmdi-sort-amount-desc"></i></button>

                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="float-right btn btn-primary btn-icon right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Basic Examples -->

            <!-- Exportable Table -->
            <div class="clearfix row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <!-- <h2><a href="<?php //echo base_url('fund_admin_wallet/adds_user_fund'); ?>"><strong>Add
                                        Fund Type</strong></a>
                            </h2> -->
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i> </a>
                                    <!-- <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul> -->
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Transaction Reference</th>
                                            <th>Username</th>
                                            <th>Fund Name</th>
                                            <th>Amount</th>
                                            <th>Wallet Balance</th>
                                            <th>Operation Type</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($customer_wallets)): ?>
                                        <?php $sn = 1; foreach ($customer_wallets as $wallet): ?>
                                        <tr>
                                            <td><?= $sn++; ?></td>
                                            <td><?= htmlspecialchars($wallet['transaction_reference']); ?></td>
                                            <td><?= htmlspecialchars($wallet['username']); ?></td>
                                            <td><?= htmlspecialchars($wallet['fundname']); ?></td>
                                            <td><?= htmlspecialchars($wallet['amount']); ?></td>
                                            <td><?= htmlspecialchars($wallet['wallet_balance']); ?></td>
                                            <td><?= htmlspecialchars($wallet['operation_type']); ?></td>
                                            <td><?= htmlspecialchars($wallet['description']); ?></td>
                                            <td><?= htmlspecialchars($wallet['status']); ?></td>
                                            <td><?= htmlspecialchars($wallet['insert_dt']); ?></td>
                                            <!-- <td>
                                                <a href="<?php // echo base_url('customer_wallets/view/' . $wallet['id']); ?>"
                                                    class="btn btn-info btn-sm">View</a>
                                            </td> -->
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No wallet transactions found</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>