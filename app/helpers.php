<?php
function replaceSpace($data)
{
    return str_replace('_', ' ', $data);
}
function replaceSlash($data)
{
    return str_replace('_', '/', $data);
}
function replaceLine($data)
{
    return str_replace(' ', '_', $data);
}
function foodBackend($food)
{
    $better = replaceSpace($food);
    return replaceSlash(strtolower($better));

}
function changeColorToStatus($status)
{
    if($status=="Accepted") { return "class=text-success";}
    else if($status=="Pending") { return "class=text-warning";}
    else if($status=="Declined") { return "class=text-danger";}
    else if($status=="Completed") { return "class= text-primary";}
}

function checkIfNull($obj) {
    if($obj != null ) { return false; }
    else              { return true; }
}
function displayFood($food)
{
    switch ($food) {
        case "water":
            return "/L";
            break;
        case "fruits":
            return "pieces";
            break;
        case "vegetables":
            return "pieces";
            break;
        case "bread":
            return "slices";
            break;
        case "dairy":
            return "/L";
            break;
        case "fish":
            return "/g";
            break;
        case "meat":
            return "/g";
            break;
        case "body_care":
            return "bottles";
            break;
        case "other":
            return "";
            break;
    }
}