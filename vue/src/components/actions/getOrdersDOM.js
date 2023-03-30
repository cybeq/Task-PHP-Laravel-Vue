module.exports = function(orders){
    const container = document.createElement('div');
    let summary = 0;
    for(let order of orders){
        summary+=order.price;
        const div = document.createElement('div')
        div.innerHTML=`<p style="text-decoration: underline 2px cadetblue">${order.name} : ${order.price} ,-</p>`
        container.appendChild(div);
    }
    const div = document.createElement('div');
    div.style.width="100%";
    div.style.height="10px"
    div.style.background="black"
    container.appendChild(div)


    container.innerHTML+=`<p style="font-size:1.2em;">Suma: ${summary} ,-</p>`
    return container;
}