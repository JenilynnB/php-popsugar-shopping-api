<?php
error_reporting(-1); ini_set('display_errors', 1);
/**
 *
 * @file Contains classes for accessing ShopStyle
 *
 * ShopStyleAPIExample.php contains sample implementation of a application client using ShopStyle.class.php
 *
 * See api doc for ShopStyle at: http://www.shopstyle.com/static/api/index.html
 *
 * LICENSE:Copyright (c) 2009 Sugar Inc. http://corp.popsugar.com
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * @copyright2013Sugar Inc.
 * @license M.I.T.
 * @version$Id:$
 */


include("../src/ShopStyle/API.php");
include("../src/ShopStyle/Query/IQuery.php");
include("../src/ShopStyle/Query/BasicQuery.php");

function enc($text)
{
    return htmlspecialchars($text, null, 'utf-8');
}

//decide if the search has already been performed.
if (isset($_REQUEST["searchCmd"]) && ($_GET["searchCmd"] == "Search")) {
    $searchFlag = true;
} else {
    $searchFlag = false;
}

// pager attributes
$selfUrl = $_SERVER['PHP_SELF'];
$perPage = isset($_REQUEST["perPage"]) ? $_GET["perPage"] : 10;
$currentPage = isset($_REQUEST["page"]) ? $_GET["page"] : 1;
$offset = ($currentPage - 1) * $perPage;

if ($searchFlag) {
    //get the query string
    $queryStr = $_GET["searchString"];
} else {
    // defaut it to blue pants, if no search string given.
    $queryStr = "blue pants";
}

//create a new instance of shopstyle object, with only partner id and accepting default values for others.
$shopstyle = new ShopStyle\API('sugar');
//invoke search with parameters passed in
$result = $shopstyle->search($queryStr, $perPage, $offset);

//calculate pager attributes
$totalCount = $result->metadata->total; //total number of results available in Shopstyle for the queryString
$resultCount = count($result->products); //count of resultset that we are dealing with now

function getPageUrl($url, $page, $query, $perPage)
{
    $data = array(
        'page' => $page,
        'searchString' => $query,
        'perPage' => $perPage,
        'searchCmd' => 'Search'
    );

    return $url . '?' . http_build_query($data);
}
?>


<html>
<head>
    <title>Search Results</title>
    <style>
        body {
            color: #000000;
            font-family: verdana, arial, helvetica, sans-serif;
            font-size: 8pt;
        }

        .productImage {
            padding: 0;
            margin: 0;
            float: left;
            height: 300px;
        }

        .strike {
            text-decoration: line-through;
            font-size: 8pt;
        }

        .salePrice {
            text-decoration: none;
            text-align: center;
            font-size: 8pt;
        }

        img {
            border: none;
            padding: 0;
            margin: 0;
        }

        td {
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .prodDesc {
            overflow: hidden;
            font-size: 8pt;
            height: 2.4em;

        }

        .pager {
            font-size: 8pt;
            height: 1em;
            float: right;
        }

        .pager span {
            margin-right: 5px;
        }

        .pager a {
            margin-right: 3px
        }

        .results {
            display: block;
            border: 1px none;
            padding: 0;
            margin: 5px;
        }

        .clear {
            clear: both;
        }

        .thumb {
            text-align: center;
            vertical-align: middle;
            max-width: 210px;
        }

        .info {
            float: left;
            margin: 5px;
        }
    </style>
</head>
<body>
<form method="get" action="<?php echo enc($selfUrl);?>">
    <label for="search">Search: </label>
    <input type="text" name="searchString" id="search"
           value="<?php echo enc($queryStr) ?>"/>
    <input type="submit" name="searchCmd" value="Search"/>
</form>

<span class="info">
    Your search for <b><i><?=enc($queryStr)?></i></b>
    resulted in <?=number_format($totalCount)?> results
</span>

<?php if ($totalCount) : ?>
<span class="pager">
    <span>
        <?=number_format($currentPage)?>
        of
        <?=number_format(ceil($totalCount / $perPage))?>
    </span>
    <span>
        <?php if ($currentPage != 1): ?>
            <a href="<?=getPageUrl($selfUrl, ($currentPage - 1), $queryStr, $perPage) ?>">Prev</a>
        <?php endif ?>

        <?php if ($currentPage < ceil($totalCount / $perPage)): ?>
            <a href="<?=getPageUrl($selfUrl, ($currentPage + 1), $queryStr, $perPage) ?>">Next</a>
        <?php endif ?>
    </span>
<span>
<div class="clear"></div>

<div class="results">
    <?php foreach ($result->products as $product): ?>
        <table class="productImage" style="width:<?=$product->image->sizes->XLarge->width?>px;">
            <tr>
                <td class="thumb">
                    <a href="<?=$product->clickUrl?>">
                        <img src="<?=$product->image->sizes->XLarge->url?>"/>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="prodDesc">
                        <?=enc($product->name)?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if (isset($product->salePrice)): ?>
                        <span class="strike">$<?=money_format('%i', $product->price)?></span>
                        <span class="salePrice">$<?=money_format('%i', $product->salePrice)?></span>
                    <?php else : ?>
                        <span class=salePrice>$<?=money_format('%i', $product->price)?></span>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class=prodDesc><a href="<?=$product->clickUrl?>">Buy Now</a></div>
                </td>
            </tr>
        </table>
    <?php endforeach ?>

</div>
<div class="clear"></div>
    <?php endif ?>

