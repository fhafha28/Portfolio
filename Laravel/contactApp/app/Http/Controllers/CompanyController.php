<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::allowedTrash()
            ->forUser(auth()->user())
            ->allowedSorts(['name', 'website', 'email'], '-id')
            ->allowedSearch('name', 'website', 'email')
            ->withCount("contacts")
            //eager loading 방지용
            ->paginate(10);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //생성페이지 넘어가기용

    public function create()
    {
        $company = new Company();
        return view('companies.create', compact('company'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

//저장 버튼 누르면 실행될 것임
//    CompanyRequest라는 파일을 Requests 폴더 안에 만들어서 validation 규칙 지정할 거임.
    public function store(CompanyRequest $request)
    {
        $request->user()->companies()->create($request->validated());
//        그 user랑 새로 집어넣을 회사 데이터랑 연걸 시킨 다음에 validation이 완료되면  데이터 생성
        return redirect()->route('companies.index')
            ->with('message', 'Company has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show')
            ->with('company', $company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        return redirect()->route('companies.index')->with('message', 'Company has been updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect):back())
            ->with('message', 'Company has been deleted successfully')
            ->with('undoRoute', getUndoRoute('companies.restore', $company))
            ;
    }

    public function restore(Company $company){
        $company -> restore();
        return back()
            ->with('message', 'Company has been restored from trash')
            ->with('undoRoute', getUndoRoute('companies.destroy', $company))
            ;
    }

    public function forceDelete(Company $company){
        $company->forceDelete();
        return back()
            ->with('message', 'Company has been removed permanently')
            ;
    }
}
