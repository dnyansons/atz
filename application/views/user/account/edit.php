<?php $this->load->view("user/common/header"); ?>
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-header">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
    <div class="d-inline">
        <h4>Account Details</h4>
        <span></span>
    </div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>seller/dashboard"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#">Account Details</a></li>
    </ul>
</div>

</div>
</div>
</div>
<div class="page-body">

<div class="row">
<div class="col-lg-12">
<div class="tab-header card">
    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
            <div class="slide"></div> 
        </li>

    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="personal" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <?php echo $this->session->flashdata("message");?>

            </div>
            <div class="card-block">
                <div class="view-info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="general-info">
                                <form action="<?php echo site_url(); ?>seller/myaccount/edit_profile" method="post" name="edit_profile">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table m-0"> 
                                                    <tbody> 
                                                        <tr>
                                                            <th scope="row">First Name</th> 
                                                            <td>
                                                                <input class="form-control" type="text" name="first_name" value="<?php echo $user->first_name; ?>">
                                                                <?php echo form_error("first_name");?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Last Name</th> 
                                                            <td>
                                                                <input class="form-control" type="text" name="last_name" value="<?php echo $user->last_name; ?>">
                                                                <?php echo form_error("last_name");?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Company Type</th>
                                                            <td>
                                                                <select class="form-control" name="company_type">
                                                                    <option value="">Select Company Type</option>
                                                                    <?php foreach($company as $comp):?>
                                                                    <?php if($comp["name"] == $user->companyType){?>
                                                                    <option value="<?php echo $comp['id'];?>" selected="selected"><?php echo $comp['name'];?></option>
                                                                    <?php } else { ?>
                                                                    <option value="<?php echo $comp['id'];?>"><?php echo $comp['name'];?></option>
                                                                    <?php } endforeach;?>
                                                                </select>
                                                                <?php echo form_error("company_type");?>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Address</th>
                                                            <td>
                                                                <textarea class="form-control" name="address"><?php echo $user->address;?></textarea>
                                                                <?php echo form_error("address");?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Email</th>

                                                            <td><a href="#!"><?php echo $user->email; ?></a></td> 
                                                        </tr> 
                                                        <tr>
                                                            <th scope="row">Company Name</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="company_name" value="<?php echo $user->company_name; ?>">
                                                                <?php echo form_error("company_name");?>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Mobile Number</th>
                                                            <td><?php echo $user->phone;?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <input type="submit" class="btn btn-info pull-right" value="Update">

                                            </div>
                                        </div>

                                    </div>
                                </form>
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
</div>
<?php $this->load->view("user/common/footer"); ?>
