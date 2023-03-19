<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Repositories\CompanyRepository;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
//validatin 관련 설정 들어가 있음

class ContactController extends Controller
{

//  public function __construct(){
//      $this ->company = new CompanyRepository();
//  }  이건 Dependency injection을 사용하여 CompanyRepository를 활용할 경우 필요함.

//  public function index(Request $request)
//  {

    protected function userCompanies(){
        return Company::forUser(auth()->user())->orderBy('name')->pluck('name', 'id');
    }

    public function index()
    {
//      DB::enableQueryLog();

//      $request->user();
//      Auth::user();
//      dd(Auth::user());
//      Auth::id();
//      auth()->id();
//      if(Auth::check()){ dd('Sign in'); } else { dd('Guest'); }


//      $query = Contact::query();

//        $companies = $this->company->pluck(); Company 레포지토리를 사용할 경우
        $companies=$this->userCompanies();

        $contacts= Contact::allowedTrash()
//        if(request()->query('trash')){
//            $query->onlyTrashed();
//        }
            ->forUser(auth()->user())
//      $contacts=auth()->user()->contacts()
            ->AllowedFilter('company_id')
            ->allowedSorts(['first_name', 'last_name', 'email'], "-id")
            ->AllowedSearch('first_name', 'last_name', 'email')
//            where(function($query){
//                if($search=request()->query('search')){
//                    $query->where("first_name", "LIKE", "%{$search}%");
//                    $query->orwhere("last_name", "LIKE", "%{$search}%");
//                    $query->orwhere("email", "LIKE", "%{$search}%");
//                }
//               SQL =  from `contacts` where (`company_id` = ?) and (`first_name` LIKE ? or `last_name` LIKE ? or `email` LIKE ?)"
//            })
            ->with('company')
            ->paginate(10000);

//        dump(DB::getQueryLog());


//        $contactsCollection= Contact::latest()->get();
//        $perPage = 10;
//        $currentPage = request()->query('page',1);
//        $items = $contactsCollection -> slice($currentPage*$perPage - $perPage, $perPage);
//        $total = $contactsCollection->count();
//        new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
//            'path' => request()->url(),
//            'query'=>request()->query()
//        ]);
//        dd(request());

        return view('admin.contacts.index', compact('contacts', 'companies'));
    }

//데이터 생성 페이지로 이동 및 같이 딸려보내야 할 모델들
    public function create(){
        $companies=$this->userCompanies();
        $contact= new Contact();
        return view('admin.contacts.create', compact('companies', 'contact'));
    }

//    protected function findContact($id){
//        return Contact::findOrFail($id);
//    }

    public function show(Contact $contact){
//        $contact =Contact::findOrFail($id);
//       $contact=$this->findContact($id);
        return view('admin.contacts.show')
            ->with('contact', $contact);
    }


//저장버튼 딱 눌렀을 때 생길 일듯.
    public function store(ContactRequest $request){
//        $request->validate($this->rules());
//        App-> Http폴더 ->requests 폴더->ContactRequest.php

//        $contact=Contact::create($request->all());
        $request->user()->contacts()->create($request->all());

//        return $contact;
//        return response()->json([
//            'success'=>true,
//            'date'=>$contact
//        ]);
//        return redirect("admin.contacts");
        return redirect()->route('admin.contacts.index')->with('message', 'Contact has been added successfully');
    }

    public function edit(Request $request, Contact $contact){
//        $contact =Contact::findOrFail($id);
        $companies=$this->userCompanies();
        return view('admin.contacts.edit', compact('companies', 'contact'));
    }


    public function update(ContactRequest $request, Contact $contact){
//        $contact =Contact::findOrFail($id);
//        $request->validate($this->rules());
        $contact->update($request->all());
        return redirect()->route('admin.contacts.index')->with('message', 'Contact has been updated successfully');
    }




    public function destroy(Contact $contact){
//        $contact =Contact::findOrFail($contact);
        $contact->delete();
        $redirect = request()->query('redirect');
        return ($redirect ? redirect()->route($redirect):back())
            ->with('message', 'Contact has been deleted successfully')
            ->with('undoRoute', getUndoRoute('admin.contacts.restore', $contact))
            ;
//        원래 $this->getUndoRoute(어쩌구) 였는데 getUndoRoute의 정의를 helper로 옮겨서 저렇게 바뀜
    }

    public function restore(Contact $contact){
//        $contact =Contact::onlyTrashed()->findOrFail($id);
//        이부분 적용을 위해 web.php 수정했음.

        $contact->restore();
        return back()
            ->with('message', 'Contact has b een restored from trash')
            ->with('undoRoute', getUndoRoute('admin.contacts.destroy', $contact))
            ;
    }


    public function forceDelete(Contact $contact){
//        $contact =Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();
        return back()
            ->with('message', 'Contact has been removed permanently')
            ;
    }


}

