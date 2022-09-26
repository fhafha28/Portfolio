import { useNavigate } from "react-router-dom";
import axios from 'axios'

import Card from 'react-bootstrap/Card';


function Mainpage(props) {
  let navigate = useNavigate();
  let count = 0;


  return (
    <>

      <div className='main-background'>
        <h4 className="main-title">Buy Our Shoes! Now on Sale</h4>
        <p className="main-content">Sustainable Summer Styling</p>
      </div>
      <div className="shop-bg">
        <div className="shop-frame">
          {props.shoes.map((a, i) => {
            return (
              <Shopitem key={i} shoes={props.shoes[i]} i={i}></Shopitem>
            )
          })}

        </div>
        <div className="clearBoth"></div>

        <button className="btn btn-secondary more" id="more" onClick={(e) => {
          if (count == 0) {
            axios.get('https://codingapple1.github.io/shop/data2.json').then((result) => {
              let copy = [...props.shoes];
              copy.push(...result.data);
            })
              .catch((error) => { console.log(error) })
          }
          count = +1;
        }}>More</button>

      </div>
    </>
  )
}

function Shopitem(props) {
  let navigate = useNavigate();
  return (

    <Card className="shop-item" onClick={
      () => {
        navigate('/detail/' + props.shoes.id);
        let select = JSON.stringify([props.shoes]);
        if (localStorage.getItem('history') == null) {
          localStorage.setItem('history', select);
        }
        else if (localStorage.getItem('history') !== null) {
          let original = JSON.parse(localStorage.history);

          original.forEach(function (a, i) {
            let check = original.findIndex((a) => { return a.id == props.shoes.id });
            if (check == -1) {
              original.push(props.shoes);
              console.log(original);
              localStorage.setItem('history', JSON.stringify(original));
            }
          })
        }
      }}>

      <Card.Img className="item-img" variant="top" src={'https://fhafha28.cafe24.com/img/product' +
        props.shoes.id + '.jpg'} />
      <Card.Body>
        <Card.Title className="item-title">{props.shoes.title}</Card.Title>
        <Card.Text>
          {props.shoes.price}
        </Card.Text>
      </Card.Body>

    </Card>

  )
}


export { Mainpage, Shopitem};