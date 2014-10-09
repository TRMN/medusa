<?php

class ApiController extends BaseController
{

    public function getBranchList()
    {
        $results = Branch::all(array('branch', 'branch_name'));
        $branches[''] = "Select a Branch";

        foreach ($results as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        return Response::json($branches);

    }

    public function getCountries()
    {
        $results = Countries::getList();
        $countries = array();

        foreach($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        $countries = array('' => 'Select a Country') + $countries;

        return Response::json($countries);
    }

    public function getGradesForBranch($branchID)
    {
        $results = Grade::all();
        $grades[''] = "Select a Rank";

        foreach ($results as $grade) {
            if (empty($grade->rank[$branchID]) === false) {
                $grades[$grade->grade] = $grade->rank[$branchID] . ' (' . $grade->grade . ')';
            }
        }
        ksort($grades, SORT_NATURAL);

        return Response::json($grades);
    }

    public function getChapters()
    {
        $results = Chapter::all();
        $chapters = array();

        foreach ($results as $chapter) {
            $chapters[$chapter->_id] = $chapter->chapter_name;

            if (isset($chapter->hull_number) === true && empty($chapter->hull_number) === false) {
                $chapters[$chapter->_id] .= ' (' . $chapter->hull_number . ')';
            }
        }

        asort($chapters, SORT_NATURAL);

        $chapters = array('' => "Select a Chapter") + $chapters;

        return Response::json($chapters);
    }

    public function getRatingsForBranch($branchID)
    {
        $results = Rating::all();
        $ratings = array();

        foreach ($results as $rating) {
            if (isset($rating->rate[$branchID]) == true && empty($rating->rate[$branchID]) === false) {
                $ratings[$rating->rate_code] = $rating->rate[$branchID]['description'] . ' (' . $rating->rate_code . ')';
            }
        }

        ksort($ratings, SORT_NATURAL);

        if (count($ratings) > 0) {
            $ratings = ['' => 'Select a Rating'] + $ratings;
        } else {
            $ratings = ['' => 'No ratings available for this branch'];
        }

        return Response::json($ratings);
    }
} 
