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
function displayFoodText($food)
{
    return ucfirst(str_replace('_', ' ', $food));
}

function checkIfNull($obj) {
    if($obj != null ) { return false; }
    else              { return true; }
}
function displayFoodUnit($food)
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
function displayFoodQuantity($amount, $food)
{
    switch ($food) {
        case "water":
            return round($amount,2) . "l";
            break;
        case "fruits":
            return round($amount) . " pieces";
            break;
        case "vegetables":
            return round($amount) . " pieces";
            break;
        case "bread":
            return round($amount) ." slices";
            break;
        case "dairy":
            return round($amount,2) . "l";
            break;
        case "fish":
            if($amount < 1000) {
                return round($amount) . "g";
            }
            else {
                return presentWeightToKg($amount, false);
            }
            break;
        case "meat":
            if($amount < 1000) {
                return round($amount) . "g";
            }
            else {
                return presentWeightToKg($amount, false);
            }
            break;
        case "body_care":
            return round($amount) . " bottles";
            break;
        case "other":
            return round($amount);
            break;
    }
}

function presentWeightToKg($weight, $isWeightKg)
{
    if($isWeightKg) {
        // Weight = already in kg
        return round($weight, 2) . "kg";
    }
    else {
        // Weight is in gram
        return round($weight / 1000, 2) . "kg";
    }
}