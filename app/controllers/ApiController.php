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
        if (Input::file('file')->isValid() === true) {
            $res = User::where('member_id','=', Input::get('member_id'))->get();

            if (count($res) === 1 && $res[0]->member_id == Input::get('member_id')) {

                $user = $res[0];
                $ext = Input::file('file')->getClientOriginalExtension();
                $fileName = $user->member_id . '.' . $ext;

                Input::file('file')->move(public_path() . '/images', $fileName);

                // File uploaded, add filename to user record
                $user->filePhoto = '/images/' . $fileName;
                $user->save();
            }
        }
    }
}
