
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
  <title> Domain Checker &amp; Whois Lookup</title>
  <meta name="description" content="domainchecker and whois lookup scripts using ajax">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="wrap-content">
          <div class="row">
            <!-- form -->
            <form method="post" action="request.php" id="checkdomain1" class="formdomain">
              <div class="col-lg-8 col-lg-offset-2">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                  <input type="text" class="form-control" name="domain" placeholder="Domain name eg: domain.com">
                  <input type="hidden" name="request" value="single">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                    </span>
                </div>
              </div>
            </form>
          </div>

        <div class="form tab-pane fade" id="whoischeck">

          <h2>WHOIS LOOKUP </h2>

          <div class="row">
            <!-- form -->
            <form method="post" action="request.php" id="checkdomain2" class="formdomain">
              <div class="col-lg-8 col-lg-offset-2">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                  <input type="text" class="form-control" name="domain" placeholder="Domain name eg: domain.com">
                  <input type="hidden" name="request" value="whois">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                    </span>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="form tab-pane fade" id="masscheck">
          <h2> MASS DOMAIN NAME CHECK </h2>

          <div class="row">
            <!-- form -->
            <form method="post" action="request.php" id="checkdomain3" class="formdomain">
              <div class="col-lg-8 col-lg-offset-2">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                  <input type="text" class="form-control" name="domain" placeholder="eg : domain.com (or just) domain">
                  <input type="hidden" name="request" value="masscheck">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                    </span>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="form tab-pane fade" id="bulkcheck">

          <h2>BULK DOMAIN CHECKER </h2>

          <div class="row">
            <!-- form -->
            <form method="post" action="request.php" id="checkdomain4" class="formdomain">
              <div class="col-lg-8 col-lg-offset-2">
                  <textarea class="form-control" rows="3" name="domain" placeholder="Domain name separate by commas , eg: domain.com, domain2.com "></textarea>
                  <input type="hidden" name="request" value="bulkcheck">
                  <p>&nbsp;</p>
                  <p><button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button></p>
              </div>
            </form>
          </div>
        </div>

        <div class="form tab-pane fade" id="checkboxcheck">

          <h2>BULK DOMAIN CHECKER CHECKBOX </h2>

          <div class="row">
            <!-- form -->
            <form method="post" action="request.php" id="checkdomain5" class="formdomain">
              <div class="col-lg-8 col-lg-offset-2">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                  <input type="text" class="form-control" name="domain" placeholder="eg : domainname ">
                  <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
                  </span>
                </div>
                  <p>&nbsp;</p>
                  <!-- checkbox list -->
                  <p class="text-center">
                    <!--checkbox as name ext[] added '[]' determine as array -->
                    <label><input name="ext[]" type="checkbox" value=".com">.com</label>
                    <label><input name="ext[]" type="checkbox" value=".net">.net</label>
                    <label><input name="ext[]" type="checkbox" value=".org">.org</label>
                    <label><input name="ext[]" type="checkbox" value=".info">.info</label>
                    <label><input name="ext[]" type="checkbox" value=".co">.co</label>
                  </p>
                  <input type="hidden" name="request" value="bulkcheckbox">
              </div>
            </form>
          </div>
        </div>
      </div>
    <!-- end .tab-content -->
  </div>
  <!-- ************************************ results ***************************************
  *******************************   result use as modals     **************************-->

  <div class="modal fade" id="domainresults">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">LOOK UP DOMAIN</h4>
        </div>
        <div class="modal-body">

        <!-- see on ajax.js loadingdomain id , will display is on submit, so give display:none on css when
        form on submit -->
        <div id="loadingdomain">
          <div class="glyphicon glyphicon-cog animate-spin-list"></div>

          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
            </div>
          </div>

          </div>
          <!-- show the result , with id #showdomain _> please refer the ajax.js -->
          <div id="showdomain"><!-- will print result here --></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /#domainresults  and use as modal-->

  <!-- javascript -->
  <script type="text/javascript" src="assets/jquery.js"></script>
  <script type="text/javascript" src="assets/jquery-migrate.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/app.js"></script>
</body>
</html>