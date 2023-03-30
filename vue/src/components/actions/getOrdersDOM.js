
module.exports = function(client){
    const container = document.createElement('div');
    const leftGrid  = document.createElement('div');
    leftGrid.style.width="45%"
    const rightGrid = document.createElement('div');


    let summary = 0;
    for(let order of client.orders){
        summary+=order.price
        const div = document.createElement('div')
        div.innerHTML=`<p style="text-decoration: underline 2px cadetblue">${order.name} : ${order.price} ,-</p>`
        leftGrid.appendChild(div);
    }



    for(let car of client.cars){
        const div = document.createElement('div')
        div.innerHTML=`<div style="background:cadetblue; padding:5px;font-family:PoppinsMedium, sans-serif; color: orange;">
        Auta klienta</div>`
        div.innerHTML+=`<p style="border-bottom:1px solid #00000030; background:#98c6c7;margin-block:0; padding-inline:5px; padding-block:2px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            ${car.name} </p>`
        rightGrid.appendChild(div);
    }

    const div = document.createElement('div');
    div.style.width="100%";
    div.style.height="10px"
    div.style.background="black"

    leftGrid.appendChild(div)
    container.appendChild(leftGrid)


    container.innerHTML+=`<p style="font-size:1.2em;">Suma: ${summary} ,-</p>`


    container.appendChild(div.cloneNode())
    container.appendChild(rightGrid)
    return container;
}