<?php $this->load->view("admin/common/header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/pages/nestable/nestable.css">
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Categories</h4>
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
                                    <li class="breadcrumb-item"><a href="#">Category List</a></li>
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
                                    <h5>Categories Table</h5>
                                    <a href="<?php echo base_url(); ?>admin/categories/addcategory">
                                        <button type="button" class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger" data-modal="modal-13"> <i class="icofont icofont-plus m-r-5"></i> Add Category
                                        </button>
                                    </a>
                                </div>
                                <div class="card-block">
                                    <?php echo $this->session->flashdata("message");?>
                                    <div class="dt-responsive table-responsive">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="dd" id="nestableCats">
                                                    <ol class="dd-list">
                                                        <?php foreach($categories as $cat):?>
                                                        <li class="dd-item" data-id="<?php echo $cat->category_id;?>">
                                                            <div class="dd-handle"><?php echo $cat->categories_name;?></div>
                                                            <ol class="dd-list">
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                            </ol>
                                                        </li>
                                                        <?php endforeach;?>
<!--                                                        <li class="dd-item" data-id="2">
                                                            <div class="dd-handle">Item 2</div>
                                                            <ol class="dd-list">
                                                                <li class="dd-item" data-id="3">
                                                                    <div class="dd-handle">Item 3</div>
                                                                </li>
                                                                <li class="dd-item" data-id="4">
                                                                    <div class="dd-handle">Item 4</div>
                                                                </li>
                                                                <li class="dd-item" data-id="5">
                                                                    <div class="dd-handle">Item 5</div>
                                                                    <ol class="dd-list">
                                                                        <li class="dd-item" data-id="6">
                                                                            <div class="dd-handle">Item 6</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="7">
                                                                            <div class="dd-handle">Item 7</div>
                                                                        </li>
                                                                        <li class="dd-item" data-id="8">
                                                                            <div class="dd-handle">Item 8</div>
                                                                        </li>
                                                                    </ol>
                                                                </li>
                                                                <li class="dd-item" data-id="9">
                                                                    <div class="dd-handle">Item 9</div>
                                                                </li>
                                                                <li class="dd-item" data-id="10">
                                                                    <div class="dd-handle">Item 10</div>
                                                                </li>
                                                            </ol>
                                                        </li>
                                                        <li class="dd-item" data-id="11">
                                                            <div class="dd-handle">Item 11</div>
                                                        </li>
                                                        <li class="dd-item" data-id="12">
                                                            <div class="dd-handle">Item 12</div>
                                                        </li>-->
                                                    </ol>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
<!--                                        <table id="categoryTable" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Parent</th>
                                                    <th>Attributes</th>
                                                    <th>Specifications</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>-->
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
<script src="<?php echo base_url();?>assets/admin/pages/nestable/custom-nestable.js"></script>

<script>
    $(document).ready(function () {
        $("#nestableCats").nestable();
//        $('#categoryTable').DataTable({
//            processing: true,
//            serverSide: true,
//            ajax: {
//                url: "<?php echo base_url('admin/categories/ajax_list') ?>",
//                dataType: "json",
//                type: "POST",
//                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}},
//            columns: [
//                {data: "id"},
//                {data: "name"},
//                {data: "parent"},
//                {data: "created_at"},
//                {data: "specifications"},
//                {data: "action"},
//            ]
//
//        });
    });
</script>