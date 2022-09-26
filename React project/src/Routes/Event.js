import { Routes, Route, Link, useNavigate, Outlet } from 'react-router-dom'
import $ from 'jquery';


function Event() {
    let navigate = useNavigate();
    $(window).scroll(function () {
        let height = $(window).scrollTop();
        console.log(height);
        if (height > 500) {
            let y = ((-1 / 550) * height) + (1200 / 550);
            let y2 = ((-0.1 / 550) * height) + (0.9 - 1200 * (-(0.1 / 550)));
            $('.card-box').eq(0).css('opacity', y);
            $('.card-box').eq(0).css('transform', `scale(${y2})`);
            let y3 = ((-1 / 252) * height) + (1592 / 252);
            let y4 = ((-0.1 / 252) * height) + (0.9 - 1200 * (-(0.1 / 252)));
            $('.card-box').eq(1).css('opacity', y3);
            $('.card-box').eq(1).css('transform', `scale(${y4})`);
        }


    });
    return (
        <>
            <div className='container'>
                <div className="card-background">
                    <div className='event-titlediv'><h4 className='event-title'>Dynamic ads</h4>
                        <h4 className='event-title'> with scroll slide!</h4></div>

                    <div className="card-box">
                        <img src='https://fhafha28.cafe24.com/img/event1.jpg' />
                    </div>
                    <div className="card-box"><img src="https://fhafha28.cafe24.com/img/event2.jpg" /></div>
                    <div className="card-box"><img src="https://fhafha28.cafe24.com/img/event3.jpg" /></div>
                    <div className='eventContiner'>
                        <h4 className='event-title'>Event carousel</h4>
                        <Outlet></Outlet>
                        <button className='btn btn-blue' onClick={() => { navigate('/event/one') }}>Event 1</button>
                        <button className='btn btn-blue' onClick={() => { navigate('/event/two') }}>Event 2</button>

                    </div>

                </div>


            </div>




        </>
    )
}

export default Event;