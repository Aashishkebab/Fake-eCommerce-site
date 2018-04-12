<!-- Original source: https://github.com/Aashishkebab/Sorting-Simulator/blob/master/src/sorting_algorithms/PancakeSort.java -->

<?php
    /* Reverses arr[0..i] */
	function flip(&$arr, $i){
		$temp;
        $start = 0;
		while($start < $i){
			$temp = $arr[$start];
			$arr[$start] = $arr[$i];
			$arr[$i] = $temp;
			$start = $start + 1;
			$i = $i - 1;;
		}
	}

	// Returns index of the
	// maximum element in
	// arr[0..n-1]
	function findMax($arr, $n, $sortType){
		$mi;
        $i;
		for($mi = 0, $i = 0; $i < $n; $i = $i + 1){
			if(strtolower($arr[$i][$sortType]) > strtolower($arr[$mi][$sortType])){
				$mi = $i;
			}
		}
		return $mi;
	}

	// The main function that
	// sorts given array using
	// flip operations
	function pancakeSort(&$arr, $sortType){
		// Start from the complete
		// array and one by one
		// reduce current size by one
		for($curr_size = sizeof($arr); $curr_size > 1; $curr_size = $curr_size - 1){
			// Find index of the
			// maximum element in
			// arr[0..curr_size-1]
			$mi = findMax($arr, $curr_size, $sortType);

			// Move the maximum element
			// to end of current array
			// if it's not already at
			// the end
			if($mi != $curr_size - 1){
				// To move at the end,
				// first move maximum
				// number to beginning
				flip($arr, $mi);

				// Now move the maximum
				// number to end by
				// reversing current array
				flip($arr, $curr_size - 1);
			}
		}
	}
?>