import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux"
import { plusCount, minusCount, deleteItem, addCart } from './../store.js'
import axios from 'axios';



function Detail(props) {
  let { id } = useParams();
  props.shoes.find(function (x) {
    return x.id == id;
  });
  let [count, setCount] = useState(5);
  let [input, setInput] = useState(1);
  let [toggle, setToggle] = useState(0);
  let [cartToggle, setCartToggle] = useState(false);
  let [pageFade, setPageFade] = useState('')
  let action = useSelector((state) => { return state })
  let dispatch = useDispatch();
 
  useEffect(() => {
    if (count > 0) {
      setTimeout(() => { setCount(count - 1) }, 1000);
    }
  })

  useEffect(() => {
    if (/\D/.test(input)) { alert("Please type number") }
  }, [input])

  useEffect(() => {
    setPageFade('fade-end');
    return () => {
      setPageFade('');
    }
  })

  return (
    <>

      <div className={`container fade-start ${pageFade}`}>
        {count != 0 ? <EventPopup count={count} /> : null}
        
        <img src={'https://fhafha28.cafe24.com/img/product' + id + '.jpg'}></img>

        <h5>{props.shoes[id].title}</h5>
        {<p>Price : {props.shoes[id].price}</p>}

          <label className="qty">Qty</label><input className="qty" type='text' value='1' onChange={(e) => setInput(e.target.value)}></input>
          <button className="btn btn-blue" onClick={() => {
            let select = {id: id, name: props.shoes[id].title, count: input, price: props.shoes[id].price, size: 35}
            dispatch(addCart(select));
            setCartToggle(true);
          }}>Order</button> {cartToggle==true?<CartAlert/>:null}



        <div className="tab-container">
          <ul>
            <li className={"tab-button " + (toggle == 0 ? "tabBlue" : "tab-hide")} onClick={() => setToggle(0)}>Product
            </li>
            <li className={"tab-button " + (toggle == 1 ? "tabBlue" : "tab-deactive")} onClick={() => setToggle(1)}>Information
            </li>
            <li className={"tab-button " + (toggle == 2 ? "tabBlue" : "tab-deactive")} onClick={() => setToggle(2)}>Shipping
            </li>
          </ul>
          <div className="clearBoth"></div>
          <div className="tab-content">
            <TabContent toggle={toggle}></TabContent>
          </div>

        </div>

      </div>
    </>
  )
}


function EventPopup(props) {
  return (
    <div className="alert alert-danger popup">
      <div><span className="timercount" id="num">{props.count}</span>seconds left for a special gift!</div>
    </div>
  )
}

function CartAlert(props) {
  return (
    <div className="alert alert-secondary cartPopup">
      <div>The item has been added to your cart</div>
    </div>
  )
}

function TabContent({ toggle }) {
  let [fade, setFade] = useState('')
  useEffect(() => {
    let a = setTimeout(() => { setFade('fade-end') }, 100)
    return () => {
      clearTimeout(a)
      setFade('')
    }
  }, [toggle])
  if (toggle == 0) {
    return (<div className={`fade-start ${fade}`}>
      <div>This is product page</div>
    </div>)
  } else if (toggle == 1) {
    return (
      <div className={`fade-start ${fade}`}>
        <div>This is information page</div>
      </div>)
  } else if (toggle == 2) {
    return (
      <div className={`fade-start ${fade}`}>
        <div>This is shipping information page</div>
      </div>
    )
  }
}

export default Detail;