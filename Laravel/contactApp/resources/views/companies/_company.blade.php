<tr>
    <th scope="row">{{$companies->firstItem()+$index}}</th>
    {{--  머리번호 붙이는 부분. 개별 company item이 아니라 companies로 데이터 전체를 받아씀.--}}
    <td>{{$company->name}}</td>
    <td>{{$company->address}}</td>
    <td>{{$company->website}}</td>
    <td>{{$company->email}}</td>
    <td><a href="{{route('admin.contacts.index', ['company_id'=>$company->id])}}">
{{--        {{$company->contacts->count()}}--}}
        {{$company->contacts_count}}
{{--        eager loading써서 count하기. CompanyController에 ->withCount("contacts") 있어야 함.--}}
    </td>
    {{--쿼리 스트링으로 company id를 전달해서 해당 회사 연락처만 보이도록--}}

    {{--    contacts는 company모델에서 불러와 놨어서 쓸 수 있음.--}}
    <td width="150">
        @if ($showTrashBtn)
            {{--            Trash탭에 들어가 있는 경우--}}
            @include('shared.buttons.restore', ['action'=> route('companies.restore', $company->id)])
            @include('shared.buttons.force-delete', ['action'=>route('companies.force-delete', $company->id)])

            {{---------------------------------------------}}

        @else
            <a href='{{route('companies.show', $company->id)}}' class="btn btn-sm btn-circle btn-outline-info"
               title="Show"><i class="fa fa-eye"></i></a>
            <a href="{{route('companies.edit', $company->id)}}" class="btn btn-sm btn-circle btn-outline-secondary"
               title="Edit"><i class="fa fa-edit"></i></a>
            @include('shared.buttons.destroy', ['action'=>route('companies.destroy', $company->id)])

        @endif
    </td>
</tr>

