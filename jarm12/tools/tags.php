<?php

function atr($atr)
{
    if (gettype($atr) !== "array") {
        return $atr ?: "";
    };
    $r = "";
    foreach ($atr as $i => $v) {
        $r .= ' ' . $i . '="' . $v . '"';
    }
    return $r;
}

function tag($tag, $atr = "", $val = "", $isPair = true, $isBlank = null)
{
    $isBlank = $isBlank !== null ? $isBlank : !$isPair;
    return (($isBlank || $val) ? "<$tag" . atr($atr) . ">$val" . ($isPair ? "</$tag>" : "") : "");
}
