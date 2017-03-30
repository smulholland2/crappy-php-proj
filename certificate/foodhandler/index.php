<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
  <style>
    .collapsing-bordered-table>div>div {
      border: thin solid #ddd;
      padding: 15px;
      text-align: center;
    }
    
    .collapsing-bordered-table>div>div:hover {
      background: #1E2B41;
      color: white;
      border-color: white;
      cursor: pointer;
    }
  </style>
  <div class="container-fluid">
    <div class="col-md-12">
      <div class="page-header">
        <h1>Food Handler Certificate</h1>
      </div>
      <br />
      <!-- if location hasn't been set, hide the shortcut form. -->
      <div class="<?php echo !is_null($_SESSION['location']) ? $geoclass = 'row shortcut' : $geoclass = 'row shortcut hidden'; ?>">
        <p>Our system indicates that you are in
          <?php echo !is_null($_SESSION['location']) ? $_SESSION['location'] : false; ?>.</p>
        <p>Would you like to print your certificate from that state?</p>
        <input class="state-ref" type="hidden" value="<?php echo $_SESSION['abvr'] ?>" />
        <button class="geo-print-yes btn btn-success">Yes</button>
        <button class="geo-print-no btn btn-danger">No</button>
        <button class="geo-print-wrong btn btn-default">That's not my State!</button>
      </div>
      <!-- if location hasn't been set, hide the shortcut form. -->
      <div class="<?php echo is_null($_SESSION['location']) ? $mapclass = 'row map' : $mapclass = 'row map hidden'; ?>">
        <a href="/certificate" class="btn btn-primary">Back to Courses</a>
        <div id="collapsing-bordered-table" class="collapsing-bordered-table" style="margin-top: 30px">
          <div>
            <div id="ak" class="col-sm-12 col-md-3 dob">Alaska
              <a class="course-id hidden" href="#24"></a>
            </div>
            <div id="al" class="col-sm-12 col-md-2 usern">Alabama
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ar" class="col-sm-12 col-md-2 usern">Arkansas
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="az" class="col-sm-12 col-md-2 dob">Arizona
              <a class="course-id hidden" href="#5"></a>
            </div>
            <div id="ca" class="col-sm-12 col-md-3 dob">California
              <a class="course-id hidden" href="#2"></a>
            </div>
          </div>
          <div>
            <div id="co" class="col-sm-12 col-md-3 usern">Colorado
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ct" class="col-sm-12 col-md-2 usern">Conneticut
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="dc" class="col-sm-12 col-md-2 usern">District of Columbia
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="de" class="col-sm-12 col-md-2 usern">Delaware
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="fl" class="col-sm-12 col-md-3 dob">Florida
              <a class="course-id hidden" href="#7"></a>
            </div>
          </div>
          <div>
            <div id="ga" class="col-sm-12 col-md-3 usern">Georgia
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="hi" class="col-sm-12 col-md-2 usern">Hawaii
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="id" class="col-sm-12 col-md-2 usern">Iowa
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="il" class="col-sm-12 col-md-2 dob">Idaho
              <a class="course-id hidden" href="#13"></a>
            </div>
            <div id="in" class="col-sm-12 col-md-3 dob">Illinois
              <a class="course-id hidden" href="#14"></a>
            </div>
          </div>
          <div>
            <div id="ia" class="col-sm-12 col-md-3 usern">Indiana
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ks" class="col-sm-12 col-md-2 usern">Kansas
              <a class="course-id hidden" href="#17"></a>
            </div>
            <div id="ky" class="col-sm-12 col-md-2 usern">Kentucky
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="la" class="col-sm-12 col-md-2 usern">Louisiana
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ma" class="col-sm-12 col-md-3 usern">Massachusetts
              <a class="course-id hidden" href="#1"></a>
            </div>
          </div>
          <div>
            <div id="md" class="col-sm-12 col-md-3 usern">Maryland
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="me" class="col-sm-12 col-md-2 usern">Maine
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="mi" class="col-sm-12 col-md-2 usern">Michigan
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="mn" class="col-sm-12 col-md-2 usern">Minnesota
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="mo" class="col-sm-12 col-md-3 dob">Missouri
              <a class="course-id hidden" href="#6"></a>
            </div>
          </div>
          <div>
            <div id="ms" class="col-sm-12 col-md-3 usern">Mississippi
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="mt" class="col-sm-12 col-md-2 usern">Montana
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="nc" class="col-sm-12 col-md-2 usern">North Carolina
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="nd" class="col-sm-12 col-md-2 usern">North Dakota
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ne" class="col-sm-12 col-md-3 usern">Nebraska
              <a class="course-id hidden" href="#1"></a>
            </div>
          </div>
          <div>
            <div id="nh" class="col-sm-12 col-md-3 usern">New Hampshire
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="nj" class="col-sm-12 col-md-2 usern">New Jersey
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="nm" class="col-sm-12 col-md-2 dob">New Mexico
              <a class="course-id hidden" href="#8"></a>
            </div>
            <div id="nv" class="col-sm-12 col-md-2 usern">Nevada
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ny" class="col-sm-12 col-md-3 usern">New York
              <a class="course-id hidden" href="#1"></a>
            </div>
          </div>
          <div>
            <div id="oh" class="col-sm-12 col-md-3 dob">Ohio
              <a class="course-id hidden" href="#18"></a>
            </div>
            <div id="ok" class="col-sm-12 col-md-2 dob">Oklahoma
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="or" class="col-sm-12 col-md-2 usern">Oregon
              <a class="course-id hidden" href="#4"></a>
            </div>
            <div id="pa" class="col-sm-12 col-md-2 usern">Pennsylvania
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="ri" class="col-sm-12 col-md-3 usern">Rhode Island
              <a class="course-id hidden" href="#1"></a>
            </div>
          </div>
          <div>
            <div id="sc" class="col-sm-12 col-md-3 usern">South Carolina
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="sd" class="col-sm-12 col-md-2 usern">South Dakota
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="tn" class="col-sm-12 col-md-2 usern">Tennessee
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="tx" class="col-sm-12 col-md-2 dob">Texas
              <a class="course-id hidden" href="#12"></a>
            </div>
            <div id="ut" class="col-sm-12 col-md-3 dob">Utah
              <a class="course-id hidden" href="#9"></a>
            </div>
          </div>
          <div>
            <div id="va" class="col-sm-12 col-md-3 dob">Virginia
              <a class="course-id hidden" href="#20"></a>
            </div>
            <div id="vt" class="col-sm-12 col-md-2 usern">Vermont
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="wa" class="col-sm-12 col-md-2 usern">Washington
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="wi" class="col-sm-12 col-md-2 usern">Wisconsin
              <a class="course-id hidden" href="#1"></a>
            </div>
            <div id="av" class="col-sm-12 col-md-3 dob">West Virginia
              <a class="course-id hidden" href="#21"></a>
            </div>
          </div>
          <div style="border:1px solid white">
            <div id="wy" class="col-sm-12 col-md-3 usern">Wyoming
              <a class="course-id hidden" href="#1"></a>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="row welcome-msg hidden">
        <p>You have selected the course: <span></span>.</p>
        <button class="btn btn-primary">Go back to map</button>
        <br /><br />
        <p><strong>Please Enter Your Login Information</strong></p>
      </div>
      <br />
      <div class="row well cert-login-forms hidden">
        <form method="POST" action="http://asp.tapseries.com/certificate/ShowCertificate_.asp" class="dobform hidden">
          <input type="hidden" name="type" value="dob" />
          <input type="hidden" name="course" class="course-id-input" />
          <input type="hidden" name="dob" class="course-dob-input"/>
          <div class="form-group col-md-5 col-sm-12">
            <label for="lastname">Last Name (Apellido):</label>
            <input type="text" name="lname200" class="form-control" />
          </div>
          <div class="clearfix"></div>
          <label class="dob-label">Date of Birth (Fecha de Nacimiento):</label>
          <div class="clearfix"></div>
          <div class="form-group col-md-3">
            <select class="form-control month" name="month">
              <option selected="selected" value="month">Month</option>
              <option value="January">January(1)</option>
              <option value="February">February(2)</option>
              <option value="March">March(3)</option>
              <option value="April">April(4)</option>
              <option value="May">May(5)</option>
              <option value="June">June(6)</option>
              <option value="July">July(7)</option>
              <option value="August">August(8)</option>
              <option value="September">September(9)</option>
              <option value="October">October(10)</option>
              <option value="November">November(11)</option>
              <option value="December">December(12)</option>
            </select>
          </div>
          <div class="form-group col-md-1">
            <select class="form-control day" name="day">
              <option selected="selected" value="day">Day</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
          </div>
          <div class="form-group col-md-1">
            <select class="form-control year" name="year">
              <option selected="selected" value="year">Year</option>					  
              <option value="1925">1925</option>
              <option value="1926">1926</option>
              <option value="1927">1927</option>
              <option value="1928">1928</option>
              <option value="1929">1929</option>
              <option value="1930">1930</option>
              <option value="1931">1931</option>
              <option value="1932">1932</option>
              <option value="1933">1933</option>
              <option value="1934">1934</option>
              <option value="1935">1935</option>
              <option value="1936">1936</option>
              <option value="1937">1937</option>
              <option value="1938">1938</option>
              <option value="1939">1939</option>
              <option value="1940">1940</option>
              <option value="1941">1941</option>
              <option value="1942">1942</option>
              <option value="1943">1943</option>
              <option value="1944">1944</option>
              <option value="1945">1945</option>
              <option value="1946">1946</option>
              <option value="1947">1947</option>
              <option value="1948">1948</option>
              <option value="1949">1949</option>
              <option value="1950">1950</option>
              <option value="1951">1951</option>
              <option value="1952">1952</option>
              <option value="1953">1953</option>
              <option value="1954">1954</option>
              <option value="1955">1955</option>
              <option value="1956">1956</option>
              <option value="1957">1957</option>
              <option value="1958">1958</option>
              <option value="1959">1959</option>
              <option value="1960">1960</option>
              <option value="1961">1961</option>
              <option value="1962">1962</option>
              <option value="1963">1963</option>
              <option value="1964">1964</option>
              <option value="1965">1965</option>
              <option value="1966">1966</option>
              <option value="1967">1967</option>
              <option value="1968">1968</option>
              <option value="1969">1969</option>
              <option value="1970">1970</option>
              <option value="1971">1971</option>
              <option value="1972">1972</option>
              <option value="1973">1973</option>
              <option value="1974">1974</option>
              <option value="1975">1975</option>
              <option value="1976">1976</option>
              <option value="1977">1977</option>
              <option value="1978">1978</option>
              <option value="1979">1979</option>
              <option value="1980">1980</option>
              <option value="1981">1981</option>
              <option value="1982">1982</option>
              <option value="1983">1983</option>
              <option value="1984">1984</option>
              <option value="1985">1985</option>
              <option value="1986">1986</option>
              <option value="1987">1987</option>
              <option value="1988">1988</option>
              <option value="1989">1989</option>
              <option value="1990">1990</option>
              <option value="1991">1991</option>
              <option value="1992">1992</option>
              <option value="1993">1993</option>
              <option value="1994">1994</option>
              <option value="1995">1995</option>
              <option value="1996">1996</option>
              <option value="1997">1997</option>
              <option value="1998">1998</option>
              <option value="1999">1999</option>
              <option value="2000">2000</option>
              <option value="2001">2001</option>
              <option value="2002">2002</option>
              <option value="2003">2003</option>
              <option value="2004">2004</option>
              <option value="2005">2005</option>
              <option value="2006">2006</option>
              <option value="2007">2007</option>
              <option value="2008">2008</option>
              <option value="2009">2009</option>
              <option value="2010">2010</option>
              <option value="2011">2011</option>
              <option value="2012">2012</option>
              <option value="2013">2013</option>
              <option value="2014">2014</option>
              <option value="2015">2015</option>
              <option value="2016">2016</option>
              <option value="2017">2017</option>
            </select>
          </div>
          <div class="clearfix"></div>
          <button type="submit" class="btn btn-primary">Submit & Print</button>
        </form>
        <form method="POST" action="http://asp.tapseries.com/certificate/ShowCertificate_.asp" class="usernform hidden">
          <input type="hidden" name="lname200" />
          <input type="hidden" name="month" value="Month" />
          <input type="hidden" name="day" value="Day" />
          <input type="hidden" name="year" value="Year" />
          <div class="form-group col-md-5 col-sm-12">
            <label for="lname100">Last Name (Apellido):</label>
            <input type="text" name="lname100" class="form-control" />
          </div>
          <div class="clearfix"></div>
          <div class="form-group col-md-5 col-sm-12">
            <label for="ctname933">User Name (Nombre de Usuario):</label>
            <input type="text" class="form-control" name="ctname933" />
          </div>
          <div class="clearfix"></div>
          <button type="submit" class="btn btn-primary">Submit & Print</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modals -->

<div class="modal fade ca-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="2" checked>
            California Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="3">
            San Diego Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ca-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade ak-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="1" checked>
            Alaska Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="24">
            Anchorage, AK Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ak-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade ks-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="1" checked>
            Kansas Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="17">
            Witchita Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ks-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade va-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="1" checked>
            Virginia Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="20">
            Norfolk Virginia Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success va-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade wv-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="10" checked>
            West Virginia Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="15">
            Mid Ohio Valley Health Department West Virginia Food Worker
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="16">
            Cabell-Huntington West Virginia Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="19">
            Wayne County West Virginia Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="21">
            West Virginia State Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success wv-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modals-->
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>