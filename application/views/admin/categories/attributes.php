<?php $this->load->view("admin/common/header"); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Category Specific attributes</h4>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/dashboard"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo site_url(); ?>admin/categories">Categories</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Attributes</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="btn btn-info pull-right" href="<?php echo site_url();?>admin/categories/createAttribute/<?php echo $cat_id;?>">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Choices</th>
                                                    <th>compulsory</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             foreach($attributes as $attribute):?>
                                                <tr>
                                                    <td><?php echo $attribute->id;?></td>
                                                    <td><?php echo $attribute->name;?></td>
                                                    <td><?php echo ucfirst(humanize($attribute->type));?></td>
                                                    <td><?php echo implode(",", json_decode($attribute->choices));?></td>
                                                    <td><?php echo $attribute->is_required?"Yes":"No";?></td>
                                                    <td>
                                                        <a class="label label-info" href="<?php echo site_url('admin/categories/editAttrs/').$attribute->id;?>">
                                                            Edit
                                                        </a>
                                                        <a class="label label-danger" onclick="return confirm('are you sure?');" href="<?php echo site_url('admin/categories/delteAttrs/').$attribute->id."/".$cat_id;?>">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
<?php $this->load->view("admin/common/footer"); ?>