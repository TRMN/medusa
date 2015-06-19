<?php

class ApiController extends BaseController
{

    public function getBranchList()
    {
        return Response::json(Branch::getBranchList());
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
        return Response::json(Grade::getGradesForBranch($branchID));
    }

    public function getChapters()
    {
        return Response::json(Chapter::getChapters());
    }

    public function getChaptersByBranch($branchID) {
        return Response::json( Chapter::getChapters( $branchID ) );
    }

    public function getRatingsForBranch($branchID)
    {
        return Response::json(Rating::getRatingsForBranch($branchID));
    }

    public function savePhoto() {
        $user = Auth::user();

        if (Input::file('file')->isValid() === true) {
            $ext = Input::file('file')->getClientOriginalExtension();

            Input::file('file')->move(public_path() . '/images', $user->member_id . '.' . $ext);

            // File uploaded, add filename to user record

            $u = User::find($user->_id);
            $u->filePhoto = '/images/' . $user->member_id . '.' . $ext;
            $u->save();
        }
    }
}
