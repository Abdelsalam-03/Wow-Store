var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function viewAlert(type, message){
    alertBody = document.createElement('div');
    alertBody.classList.add('alert', 'alert-' + type, 'alert-dismissible', 'fade', 'show', 'position-fixed', 'top-0', 'start-50', 'translate-middle-x');
    alertBody.setAttribute('role', 'alert');
    content  = document.createTextNode(message);
    closeButton = document.createElement('button');
    closeButton.classList.add('btn-close', 'd-none');
    closeButton.setAttribute('type', 'button');
    closeButton.setAttribute('data-bs-dismiss', 'alert');
    closeButton.setAttribute('aria-label', 'Close');
    alertBody.appendChild(content);
    alertBody.appendChild(closeButton);
    document.body.appendChild(alertBody);
    setTimeout(function (){
        closeButton.click();
    }, 2000)
}

function cart() {
    fetch('/cart/all', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            document.getElementById('cart-indicator').classList.remove('d-none');
        }
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
        document.getElementById('cart-indicator').classList.remove('d-none');
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// function fillCart(content) {
//     cartElement = document.querySelector('.cart');
//     content.forEach(element => {
//         let component = document.createElement('div');                
//         let id = document.createElement('p');                
//         let quantity = document.createElement('p');
//         let removeBotton = document.createElement('button');
//         removeBotton.addEventListener('click', () => remove(element.product_id));
//         quantity.className = 'quantity';
//         id.innerHTML = 'Name : ' + element.product_id;
//         quantity.innerHTML = element.quantity;
//         removeBotton.innerHTML = 'Remove';
//         component.id = element.product_id + 'cart';
//         component.append(id);
//         component.append(quantity);
//         component.append(removeBotton);
//         component.append(document.createElement('hr'));
//         cartElement.appendChild(component);
//     });
// }
// function fillSpecificCart(productId) {
//     element = document.getElementById(productId + 'cart');
//     if (element) {
//         element.querySelector('.quantity').innerHTML = (+element.querySelector('.quantity').innerHTML + 1);
//     } else {
//         cartElement = document.querySelector('.cart');
//         if (cartElement) {
//             let component = document.createElement('div');                
//             let id = document.createElement('p');                
//             let quantity = document.createElement('p');
//             let removeBotton = document.createElement('button');
//             removeBotton.addEventListener('click', () => remove(productId));
//             quantity.className = 'quantity';
//             id.innerHTML = 'Name : ' + productId;
//             quantity.innerHTML = 1;
//             removeBotton.innerHTML = 'Remove';
//             component.id = productId + 'cart';
//             component.append(id);
//             component.append(quantity);
//             component.append(removeBotton);
//             component.append(document.createElement('hr'));
//             cartElement.appendChild(component);
//         }
//     }
// }

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
        if (data['to'] < data['total']) {
            more_link = document.createElement('a');
            more_link.setAttribute('href', '?query=' + query);
            more_link.innerHTML = "More...";
            resultsPanel.appendChild(more_link);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function prepareForSearch() {
    removeLiveSearchContent();
    focusOnSearchField();
}

function removeLiveSearchContent() {
    document.getElementById('live-search-results').innerHTML = '';
}

function focusOnSearchField() {
    var myModal = document.getElementById('staticBackdrop');
    
    myModal.addEventListener('shown.bs.modal', function () {
        var myInput = document.getElementById('live-search-input');
        myInput.focus();
        myInput.value = '';
    });
}

function addTagToPaginationLinks(containerId, tag){
    container = document.getElementById(containerId);
    if (container) {
        links = container.querySelectorAll('a');
        if (links) {
            links.forEach(element => {
                element.href = element.href + "#" + tag;
            });
        }
    }
}

function addEventToCartQuantity() {
    cartQuantity = document.querySelectorAll('.cart-quantity');
    cartQuantity.forEach(element => {
        element.querySelector('.quantity').addEventListener('blur', function(){
            element.submit();
        })
    })
}

function disableAddressForms(){
    forms = document.querySelectorAll('.address-form');

    forms.forEach(element => {
        element.addEventListener('submit', function(e){
            e.preventDefault();
        });
    })

}

function createUserAddress() {
    form = document.querySelector('.address-form');
    districtField = form.querySelector("input[name='district']");
    streetField = form.querySelector("input[name='street']");
    buildingField = form.querySelector("input[name='building']");
    phoneField = form.querySelector("input[name='phone']");
    if (phoneField.value.length != 11) {
        console.log('phone Field is too short');
    } else {
        const data = { 
            district: districtField.value, 
            street: streetField.value, 
            building: buildingField.value, 
            phone: phoneField.value, 
        };
        fetch('/address/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => {
    
            if (response.status >= 400 && response.status < 600) {
              return response.json().then(errorData => {
                throw new Error(errorData.message);
              });
              
            }
            
            return response.json();
          })
          .then(data => {
            viewAlert('success', data.message);
          })
        .catch(error => {
            viewAlert('danger', error);
        });
    }
}