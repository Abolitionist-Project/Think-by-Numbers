<?php

function Correlation($arr)
{        
	// Check for validity of the data
	if ( count($arr)<2 ) return "Undefined";
	
	// Calc mean deviation for X var
	$sum1=0;
	foreach ($arr as $row) $sum1 += $row[1];
	$average1 = $sum1/count($arr);		// Average for the array1
	foreach ($arr as $row) $meandeviation1[] = $row[1] - $average1;
	
	// Calc mean deviation for Y var
	$sum2=0;
	foreach ($arr as $row) $sum2 += $row[2];
	$average2 = $sum2/count($arr);		// Average for the array2
	foreach ($arr as $row) $meandeviation2[] = $row[2] - $average2;
	
    // $correlation = 0;
    // $k = SumProductMeanDeviation($arr1, $arr2);
	
	// Sum from the products of the MeanDeviations
	$spmd=0;
	foreach ($meandeviation1 as $key=>$value) $spmd += $value * $meandeviation2[$key];
	
	// Sum from the squares of the MeanDeviation1
    // $ssmd1 = SumSquareMeanDeviation($arr1);
    $ssmd1 = 0;
	foreach ($meandeviation1 as $value) $ssmd1 += $value * $value;
	
	// Sum from the squares of the MeanDeviation2
    // $ssmd2 = SumSquareMeanDeviation($arr2);
    $ssmd2 = 0;
	foreach ($meandeviation2 as $value) $ssmd2 += $value * $value;
    
    $product = $ssmd1 * $ssmd2;
    $res = sqrt($product);
	if ($res==0) return 0;
	else return $spmd / $res;
}


function stat_signific ($pear) {
	if ($pear==0) return "None";
	switch ((float)$pear) {
		case ($pear < -0.5): return "Large Negative";
		case ($pear < -0.3): return "Medium Negative";
		case ($pear < -0.1): return "Small Negative";
		case ($pear <  0.1): return "None";
		case ($pear <  0.3): return "Small";
		case ($pear <  0.5): return "Medium";
		case ($pear >= 0.5): return "Large";
	}
}

// for ($i=-1; $i<1.5; $i+=0.1) print stat_signific ($i)." => $i \n";
// print stat_signific (0.0);

?>