<?php $this->load->view("front/common/header"); ?>
<div class="help-center" data-role="help-center" style="background:#fff">
    <div class="mod-top-nav" data-role="top-nav"></div>

    <div class="mod-main container-fluid px-4 homepage" data-role="homepage" style="margin-bottom:0;">
        <div class="col-md-12 mod-main-content util-clearfix">
            
            <div class="col-left">
                <div class="col-left-content" >
                    <a href="<?php echo site_url();?>about_us"><strong>About ATZ CART</strong></a>
                    <div class="menu-item mt-2">
                        <p class="pt-2">
                            ATZCART is a new e-commerce platform for B2B as well as B2C markets.
                        </p>

                    </div>
                    <div class="menu-item">
                        <p>
                            More than 36 main categorised products.
                        </p>

                    </div>
                    <div class="menu-item">
                        <p>
                            Maximum buying benifits.
                        </p>

                    </div>
                    <div class="menu-item">
                        <p>
                            Maximum rate of customer fulfillment.
                        </p>

                    </div>



                </div>
            </div>
            <div class="col-right">
                <div class="col-right-content">
                    <div class="main-content">
                        <div class="banner" data-role="banner" style="min-height: 208px;">
                            <ul class="util-clearfix ui-switchable-panel">
                                <li>
                                    <a>
                                        <img src="<?php echo base_url();?>assets/images/banners/banner_investor_overview.jpg">
                                        <div class="main-slider-wrapper" style="top:32% !important">
                                            <div class="text-left" style="color:#bd081b; padding-left: 35px; padding-top: 5px; font-size: 25px; font-weight: bold">
                                                <span >Easy investment with ATZCart!</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php echo $this->session->flashdata("msg");?>
                        <div class="intro-wrap intro-wrap-1 util-clearfix">
						<div class="card p-4" style=" box-shadow: 0 2px 8px 0 rgba(0,0,0,.05); ">
                            <h4 class="text-center" id="t1"> Investor Enquiry Form </h4>
                            <form method="post" action="<?php echo site_url();?>invest" id="frm_investorEnq">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name of investor *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address1" class="col-sm-2 col-form-label">Address line 1 *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Enter Office no/ House #, Street Name" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address2" class="col-sm-2 col-form-label">Address line 2 *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Enter Building Name, Area Name" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address3" class="col-sm-2 col-form-label">Address line 3 *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="address3" name="address3" placeholder="Enter City, District, State, PIN code" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email *</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="@">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-form-label">Mobile *</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number" maxlength="10">
                                    </div>
                                </div>
                                
                                
                                
                                <br />
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 pt-0">Type / Form of Ownership </label>
                                    <div class="col-sm-10">
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="typeofowner" id="gridRadios1" value="VC" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                &nbsp;VC
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="typeofowner" id="gridRadios2" value="Term Load">
                                            <label class="form-check-label" for="gridRadios2">
                                                &nbsp;Term Loan
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="typeofowner" id="gridRadios3" value="Equity">
                                            <label class="form-check-label" for="gridRadios3">
                                                &nbsp;Equity
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="typeofowner" id="gridRadios4" value="Other" >
                                            <label class="form-check-label" for="gridRadios3">
                                                &nbsp;Other
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">If "Other" Please specify</div>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input type="text" class="form-control" name="other" id="other" placeholder="Brief us about your ownership type in maximum 200 words" maxlength="800">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">Approx Investment amount *</div>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input type="text" class="form-control" name="amount" id="amount" maxlength="10" placeholder="Investment Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10 text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                <?php echo validation_errors();?>
                            </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("front/common/footer"); ?>
<script>
$(document).ready(function(){
    $("#frm_investorEnq").validate({
        rules : {
            name : "required",
            address1 : "required",
            address2 : "required",
            address3 : "required",
            email : {
                required : true,
                email : true,
            },
            mobile : {
                required : true,
                maxlength : 10,
                minlength : 10,
            },
            amount:{
                required : true
            }
        },
        messages : {
            name : "Please enter investor name",
            address1 : "Please enter address line 1",
            address2 : "Please enter address line 2",
            address3 : "Please enter address line 3",
            email : "Please enter valid email",
            mobile : "Please enter 10 digit mobile number",
            amount : "Please enter amount",
        },
        errorClass : "text-danger"
    })
});

// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };
}(jQuery));

$(document).ready(function() {
  // Restrict input to digits by using a regular expression filter.
  $("#amount").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
  $("#mobile").inputFilter(function(value) {
    return /^\d*$/.test(value);
  });
});
</script>
