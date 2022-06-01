<?php


namespace framework\validation\annotation;

/**
 * 正则模式修饰符
 */
enum PatternModifier: string
{
    case PCRE_CASELESS = "i";
    case PCRE_MULTILINE = "m";
    case PCRE_DOTALL = "s";
    case PCRE_EXTENDED = "x";
    case PCRE_ANCHORED = "A";
    case PCRE_DOLLAR_ENDONLY = "D";
    case S = "S";
    case PCRE_UNGREEDY = "U";
    case PCRE_EXTRA = "X";
    case PCRE_INFO_JCHANGED = "J";
    case PCRE_UTF8 = "u";
}