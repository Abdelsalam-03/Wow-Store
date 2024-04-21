var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


function cart() {
    fetch('/cart/all', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        fillCart(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function addToCart(id) {
    const data = { productId: id };
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        fillSpecificCart(id);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function destroyCart() {
    if (window.confirm("Are You Sure Want To Descard Card Content?")) {
        fetch('/cart/destroy', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.querySelector('.cart').innerHTML = '';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
function fillCart(content) {
    cartElement = document.querySelector('.cart');
    content.forEach(element => {
        let component = document.createElement('div');                
        let id = document.createElement('p');                
        let quantity = document.createElement('p');
        let removeBotton = document.createElement('button');
        removeBotton.addEventListener('click', () => remove(element.product_id));
        quantity.className = 'quantity';
        id.innerHTML = 'Name : ' + element.product_id;
        quantity.innerHTML = element.quantity;
        removeBotton.innerHTML = 'Remove';
        component.id = element.product_id + 'cart';
        component.append(id);
        component.append(quantity);
        component.append(removeBotton);
        component.append(document.createElement('hr'));
        cartElement.appendChild(component);
    });
}
function fillSpecificCart(productId) {
    element = document.getElementById(productId + 'cart');
    if (element) {
        element.querySelector('.quantity').innerHTML = (+element.querySelector('.quantity').innerHTML + 1);
    } else {
        cartElement = document.querySelector('.cart');
        if (cartElement) {
            let component = document.createElement('div');                
            let id = document.createElement('p');                
            let quantity = document.createElement('p');
            let removeBotton = document.createElement('button');
            removeBotton.addEventListener('click', () => remove(productId));
            quantity.className = 'quantity';
            id.innerHTML = 'Name : ' + productId;
            quantity.innerHTML = 1;
            removeBotton.innerHTML = 'Remove';
            component.id = productId + 'cart';
            component.append(id);
            component.append(quantity);
            component.append(removeBotton);
            component.append(document.createElement('hr'));
            cartElement.appendChild(component);
        }
    }
}
function remove(id) {
    fetch('/cart/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.getElementById(id + 'cart').remove();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function liveSearchListener(){
    document.getElementById("live-search-input").addEventListener("input", function(event) {
        if (event.target.value.trim()) {
            liveSearch(event.target.value);
        }
    });
}

function liveSearch(query) {
    fetch('/livesearch?query=' + query, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        removeLiveSearchContent();
        resultsPanel = document.getElementById('live-search-results');
        data['data'].forEach(element => {
            product = document.createElement('div');
            product_link = document.createElement('a');
            product_name = document.createElement('p');
            product_price = document.createElement('p');
            product_link.setAttribute('href', '/products/' + element.id);
            product_link.classList.add('d-flex', 'justify-content-center', 'align-items-center');
            product_name.innerHTML = element.name;
            product_price.innerHTML = element.price;
            product_link.appendChild(product_name);
            product_link.appendChild(product_price);
            product.appendChild(product_link);
            resultsPanel.appendChild(product);
            resultsPanel.appendChild(document.createElement('hr'));
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function removeLiveSearchContent() {
    document.getElementById('live-search-results').innerHTML = '';
}