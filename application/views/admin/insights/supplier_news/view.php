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
                                    <h4>View Supplier News</h4>
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
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin/BI/supplier_news');?>">Supplier News</a></li>
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
                                    <a id="edit-btn" href="<?php echo base_url('admin/BI/supplier_news/edit/'.$details['id']);?>" class="btn btn-sm btn-primary waves-effect waves-light f-right">
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
                                                                            <th scope="row">Company Name</th>
                                                                            <td><?php echo $details['company_name'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Slogan</th>
                                                                            <td><?php echo $details['slogan'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Company Profile</th>
                                                                            <td><?php echo $details['company_profile'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Company Profile Images</th>
                                                                            <td>
                                                                                <?php if (!empty($details['company_profile_images'])){ $arr = explode(',',$details['company_profile_images']); foreach($arr as $img){  ?>
                                                                                 <img src="<?php echo base_url('uploads/images/bi_company_profile_images/'.$img);?>" style="height: 30px;width: 30px">
                                                                                <?php }} ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Company Competence</th>
                                                                            <td><?php echo $details['company_competence'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Company Competence Images</th>
                                                                            <td><?php if (!empty($details['company_competence_images'])){ $arr = explode(',',$details['company_competence_images']); foreach($arr as $img){ ?>
                                                                                 <img src="<?php echo base_url('uploads/images/bi_company_competence_images/'.$img);?>" style="height: 30px;width: 30px">
                                                                            <?php } }?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Success Story</th>
                                                                            <td><?php echo $details['success_story'];?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Success Story Images</th>
                                                                            <td><?php if (!empty($details['success_story_images'])){ $arr = explode(',',$details['success_story_images']); foreach($arr as $img){ ?>
                                                                                 <img src="<?php echo base_url('uploads/images/bi_company_success_story/'.$img);?>" style="height: 30px;width: 30px">
                                                                            <?php }} ?>
                                                                            </td>
                                                                        </tr>
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
