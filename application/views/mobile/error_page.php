<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>From ATZ Cart</title>	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/font-awesome.min.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<style>

#header-inquiry {
    background-color: #fff;
    box-shadow: 0 1px 5px 0 hsla(0,0%,54%,.32);
}


#aliLogo {
    padding: 20px 0;
    font-size: 18px;
    margin-left: 10px;
}

.util-clearfix {
    zoom: 1;
}
.row-990 {
    width: 990px;
}
.row {
    margin-left: auto;
    margin-right: auto;
}
.error-404 {
  margin: 0 auto;
  text-align: center;
}
.error-404 .error-code {
  bottom: 60%;
  color: #4686CC;
  font-size: 96px;
  line-height: 100px;
  font-weight: bold;
}
.error-404 .error-desc {
  font-size: 12px;
  color: #647788;
}
.error-404 .m-b-10 {
  margin-bottom: 10px!important;
}
.error-404 .m-b-20 {
  margin-bottom: 20px!important;
}
.error-404 .m-t-20 {
  margin-top: 100px!important;
}
.notice-error, .notice-forbid {
  font-size:22px;
  margin-top:20px;
  color:#fff;
}
.notice-success, .notice-forbid {
    border: 1px solid #72a51e;
    background: #95e052;
}
.notice {
    padding: 4px 12px;
    line-height: 18px;
    font-family: Tahoma,Helvetica,Arial,\5b8b\4f53;
}
.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}
.biz-block-card-wrap {
    border: 1px solid #DCDEE3;
    background-color: #fff;
}

i{
	color:yellow;
	font-size:100px !important;
}

.jumbotron
{
	background:#c7c7c7 !important;
}

#login-error span
{
	font-size:22px;
	margin-top:15px;
}

</style>
</head>
<body>
<div id="header-inquiry" >
    <div class="container">
    <div class="row">
	    <div class="col-sm-12">
        <div id="aliLogo" class="util-clearfix">
          <a href=""><img src="<?php echo base_url(); ?>assets/images/logo.png" align="absmiddle" border="0" width="150"></a>
              </div>         
        </div>
    </div>
	</div>
</div>
<div class="error-404 container">
<br><br><br>
  <div id="productsBlock_1" class="biz-block-card-wrap biz-block-card-wrap-undefined card draft-productsBlock jumbotron">
        <div class="biz-block-card-header">		
		
	<div class="error-desc">
       <h4><?php echo $this->session->flashdata('message'); ?></h4>
	   
        <div><br/>
		
            <a href="<?php echo base_url(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Go back to Homepage</a>
        </div>
    </div>
</div>
</div>
</div>

</body>

</html>

