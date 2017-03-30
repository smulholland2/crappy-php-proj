<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Global Score Report</h1>
            </div>
            <div class="report-search-form">
                <div class="row">
                    <strong>How to Use:</strong>
                    <ol>
                        <li>To view the progress of students, click the "from" box to open the calendar and choose a date.</li>
                        <li>Click the "to" box and choose the date you wish to stop your search. If you want to list all students to date, enter today's date.</li>                    
                        <li>Click the month at the top of the calendar to quickly navigate months and years.</li>
                        <li>Click the course the students are taking and click Submit.</li>
                    </ol>
                    <br />
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form class="form">                        
                            <div class="form-group">
                                <label for="searchTo">Search Dates:</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control date" name="start" placeholder="Click here to open the 'from' calendar"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control date" name="end" placeholder="Click here to open the 'to' calendar"/>
                                </div>
                            </div>                        
                            <div class="form-group">
                                <label for="productid">Under Training Achievement Program:</label>
                                <select name="productid" size="8" class="form-control">
                                    <option value="aa">Allergen Awareness</option>
                                    <option value="ad">Allergen Plan Development</option>
                                    <option value="as">Allergen Plan Specialist</option>
                                    <option value="azfsh">Arizona Food Handler Training</option>
                                    <option value="califsh">California Food Handler Training</option>
                                    <option value="cf">Chef Fundamentals</option>
                                    <option value="cb">Cooking Basics</option>
                                    <option value="emws">Earn More With Service</option>
                                    <option value="flfsh">Florida Food Worker Training Program</option>
                                    <option value="nfon">Food Handler Training (all other states)</option>
                                    <option value="fs">Food Safety Manager Certification Training</option>
                                    <option value="refs">Food Safety Re-Certification Training</option>
                                    <option value="ifl">Food Safety Refresher Training</option>
                                    <option value="fckyfsh">Franklin County, KY Food Handler</option>
                                    <option value="nhaccp">HACCP Managers Certificate Course</option>
                                    <option value="idfsh">Idaho Food Handler Training</option>
                                    <option value="ilfsh">Illinois Food Handler Training</option>
                                    <option value="mofsh">Jackson County MO Food Handler Training</option>
                                    <option value="nmfsh">New Mexico Food Handler Training</option>
                                    <option value="vaccfsh">Norfolk VA Food Handler Training</option>
                                    <option value="ohfsh">Ohio Level One Certification</option>
                                    <option value="orfsh">Oregon Food Handler</option>
                                    <option value="fsrt">Retail Food Safety Manager Certification Training</option>
                                    <option value="casd">San Diego Food Handler</option>
                                    <option value="sfis">Strategies for Increasing Sales</option>
                                    <option value="txfsh">Texas Food Handler Training</option>
                                    <option value="tufsh">Tulsa Food Handler</option>
                                    <option value="utfsh">Utah Food Handler Training</option>
                                    <option value="wvfsh">West Virginia State Food Handler</option>
                                    <option value="ksfsh">Wichita Food Handler</option>
                                    <option value="rewi">Wisconsin Re-Certification Training</option>
                                </select>
                            </div>                    
                            <input type="submit" class="btn btn-primary" value="Submit"/>
                            <br />
                            <div class="row hidden" id="status-panel">
                                <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>NOTICE:</strong> Generating Report Data
                                </div>                 
                            </div>
                            <div class="row hidden" id="error-panel">
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error:</strong> <span class="error-log"> Generating Report Data</span>
                                </div>                 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="report-grid">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button class="btn btn-primary new-search">New Search</button>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>