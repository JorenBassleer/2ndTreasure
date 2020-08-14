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