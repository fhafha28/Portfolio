<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <a href="{{ request()->fullUrlWithQuery(['trash'=>false]) }}"
                   class="btn {{!request()->query('trash')? 'text-primary' : 'text-secondary' }} ">All</a> |
                <a href="{{ request()->fullUrlWithQuery(['trash'=>true]) }}"
                   class="btn {{request()->query('trash')? 'text-primary' : 'text-secondary' }}">Trash</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <form>
            <div class="row">
                <div class="col">
                    {{--                @includeif('admin.contacts._company-selection')--}}
                    {{--                이 UI는 어떤 경우는 보이고 어떤 경우는 안보이게 설정한 거임--}}
                    {{--                filterDropdown=드랍다운이 들어있는 블레이드파일로 설정할 것. --}}
                    {{--                이게 설정된 경우만 filterDropdown이 보일 것--}}
                    @isset($filterDropdown)
                        @includeIf($filterDropdown)
                    @endisset


                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search"
                               value="{{request()->query('search')}}" id="search-input"
                               placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2">
                        <div class="input-group-append">


                            {{--seach bar에 뭐 입력했거나 드랍다운에서 company 선택했으면 refresh버튼 보이고,
                            refresh버튼 누르면 입력값 혹은 드랍다운에서 선택한거 초기화 되고 refresh 버튼 사라짐--}}


                            <input type="hidden" name="trash" value="{{request()->query('trash')}}">
                            {{--                          쿼리에 trash가 있으면 0, 없으면 1됨. --}}


                            <button class="btn btn-outline-secondary" id="reset-filter-btn" type="button">
                                <i class="fa fa-refresh"></i>
                            </button>


                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
{{--{{"from child view"}}<br />--}}
{{--@php var_dump($companies) @endphp--}}
{{--<br />--}}

@push('scripts')
    <script>
        document.getElementById('reset-filter-btn').addEventListener('click', () => {
            let input = document.getElementById('search-input');
            let selects = document.querySelectorAll('.search-select');
            // search-select는 _company-selection 드랍다운에서 나옴. 즉, 드랍다운이 있을 경우 이것도 초기화 시키는 것.
            if (input) {
                input.value = "";
            }
            selects.forEach(select => {
                select.selectedIndex = 0;
            });
            //company를 여러개 선택했을 경우 감안하여 루프 돌면서 그 값 다 0으로 지정.

            window.location.href = window.location.href.split('?')[0];
            // 쿼리스트링 앞에는 ?들어가니까 그거 들어가는 곳의 0번째에서 잘라서 그앞에꺼만 쓴단거
        })

        const toggleClearButton = () => {
            let query = location.search;
            let pattern = /[?&]search=/;
            //&이 없거나 최대 한개. company_id&search= 이렇게 되는경우 포함하기 위해
            let button = document.getElementById('reset-filter-btn');

            if (pattern.test(query)) {
                button.style.display = "block";
                // 쿼리가 패턴과 일치하는 경우 리프레시 버튼 보일것임
            } else {
                button.style.display = "none";
            }
        }

        toggleClearButton();
    </script>
@endpush
