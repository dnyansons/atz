<?php $this->load->view("admin/common/header");?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Notifications</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url();?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/notifications');?>">Notifications</a></li>
                                    <li class="breadcrumb-item">View</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
			<div class="col-lg-12">
			    <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Details</h5>
                                    <!--<a id="edit-btn" href="<?php //echo base_url('admin/notifications/edit/'.$details['id']);?>" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                        <i class="fa fa-edit"></i>
                                    </a>-->
                                </div>
                                <div class="card-block">
                                    <div class="view-info">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="general-info">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="table-responsive">
                                                                <table class="table m-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Notification Title</th>
                                                                            <td><?php echo $details['title'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Notification Message</th>
                                                                            <td><?php echo $details['msg'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Notification Type</th>
                                                                            <td><?php echo $details['type'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Country</th>
                                                                            <td><?php echo $details['name'];?></td>
                                                                        </tr>
                                                                        <?php  if ($details['type'] == 'New Offers' || $details['type'] == 'New Products'){ ?>
                                                                            <tr>
                                                                                <th scope="row">Products</th>
                                                                                <td><?php echo $details['product_str'];?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Categories</th>
                                                                                <td><?php echo $details['categories'];?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <th scope="row">Send Date Time</th>
                                                                            <td><?php echo $details['send_date_time'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Date Created</th>
                                                                            <td><?php echo $details['date_created'];?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
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
        </div>
<?php $this->load->view("admin/common/footer");?>
