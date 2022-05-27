<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("header.php");
    if($_SESSION["logged-in"] === true) {
        echo"<div class=\"container-fluid\"><br>
                <h1> Policies</h1><br><form name=\"search\" action=\"../model/insert_policy.php\" onsubmit=\"return ValidateForm()\" method=\"post\">
                <div class=\"form-group\">
                    <input type=\"text\" name=\"site_name\" class=\"form-control\" id=\"search_input\" placeholder=\"Search...\" width='50%'>
                </div>
                </form>                        
                <form action=\"../controller/get_policies.php\" method=\"post\" name=\"filter\" class=\"form\"> 
                <div class=\"dropdown\">
                    <select type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" 
                    aria-haspopup=\"true\" aria-expanded=\"false\" name=\"filter\" class=\"btn st-border-dark-gray dropdown-toggle\">    
                    <option class=\"dropdown-item\" value=\"default\" >Select an option</option>
                        <option class=\"dropdown-item\" value=\"premiumasc\" >Lowest Premium</option>
                        <option class=\"dropdown-item\" value=\"premiumdesc\">Highest Premium</option>
                        <option class=\"dropdown-item\" value=\"insurnameasc\">Insurer Name A-Z</option>
                        <option class=\"dropdown-item\" value=\"insurnamedesc\">Insurer Name Z-A</option>
                        <option class=\"dropdown-item\" value=\"custnameasc\">Company Name A-Z</option>
                        <option class=\"dropdown-item\" value=\"custnamedesc\">Company Name Z-A</option>
                    </select>
                </div>
                <input type=\"hidden\" id=\"client_id\" name=\"client_id\" value=\"{$_SESSION["client_id"]}\">
                <br>
                <input class=\"btn btn-secondary\" type=\"submit\" id=\"submit_btn\" value=\"Apply Filter\" name=\"submit\"/>
                </form>
                <br>
                <div class=\"row\" id=\"search-content\">";
        if (!isset($_SESSION["policy_json"])) {
            echo "<script type='text/javascript'>window.top.location='https://dylan-baker.software/bicc/controller/get_policies.php?client_id={$_SESSION["client_id"]}&&filter=default';</script>"; exit;
        }
        $policy_json = $_SESSION["policy_json"];
        $policy_data = json_decode($policy_json);
        for ($j = 0; $j < count($policy_data); $j++) {
            echo "
            <div class=\"card w-50\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\"><b>{$policy_data[$j]-> customer_name}</b></h5>
                    <p class=\"card-text\" id=\"customer_address.$j.\"><b>Address:</b><br>{$policy_data[$j]->  customer_address}</p>
                    <p class=\"card-text\" id=\"policy_type.$j.\"><b>Policy Type:</b><br>{$policy_data[$j]->  policy_type}</p>
                    <p class=\"card-text\" id=\"insurer_name.$j.\"><b>Insurer:</b><br> {$policy_data[$j]->  insurer_name}</p>
                    <p class=\"card-text\" id=\"premium.$j.\"><b>Premium:</b><br>£{$policy_data[$j]->  premium}</p>
                    <a class=\"btn btn-danger\" href='../controller/remove_policy.php?policy_id={$policy_data[$j]->  policy_id}&&client_id={$_SESSION["client_id"]}' role=\"button\">
                        <i class=\"fa fa-trash\" aria-hidden=\"true\"></i>
                    </a>
                    <a class=\"btn btn-secondary\" href=\"edit_policy.php?policy_id={$policy_data[$j]->  policy_id}\" role=\"button\">
                        <i class=\"fa-solid fa-pen-to-square\" aria-hidden=\"true\"></i>
                    </a>
                </div>
            </div>";
        }echo"
        </div>
    </div>
    <script>       
        $(document).ready(function(){
                    $(\"#search_input\").on(\"keyup\", function() {
                        var value = $(this).val().toLowerCase();
                        $(\"#search-content div\").filter(function() {
                            $(this).toggle( $(this).text().toLowerCase().indexOf(value) > -1 );
                        });
                    });
                });
    </script>";
    }
else{
    header("HTTP/1.0 405 Method Not Allowed");
}
include("footer.php");


