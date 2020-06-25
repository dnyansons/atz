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
                                    <h4>View App Banner</h4>
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
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/app_banner');?>">App Banner</a></li>
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
                                    <a id="edit-btn" href="<?php echo base_url('admin/app_banner/edit/'.$details['id']);?>" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                        <i class="fa fa-edit"></i>
                                    </a>
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
                                                                            <th scope="row">Image</th>
                                                                            <td><img src="<?php echo $details['image'];?>" style="height: 100px;width: 100px"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Type</th>
                                                                            <td><?php echo $details['type'];?></td>
                                                                        </tr>
                                                                        <?php if($details['type'] == 'App'){?>
                                                                        <tr>
                                                                            <th scope="row">ON</th>
                                                                            <td><?php echo $details['on_app'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row"><?php echo $details['on_app'];  ?></th>
                                                                            <td><?php echo $details['on_app'] == 'Category' ? $details['categories_name']:$details['products_name'];?></td>
                                                                        </tr>
                                                                        <?php }else{ ?>
                                                                        <tr>
                                                                            <th scope="row">URL</th>
                                                                            <td><?php echo $details['url'];?></td>
                                                                        </tr>  
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <th scope="row">Status</th>
                                                                            <td><?php echo $details['status'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Date Created</th>
                                                                            <td><?php echo $details['date_created'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Date Modified</th>
                                                                            <td><?php echo $details['date_modified'];?></td>
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
