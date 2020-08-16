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