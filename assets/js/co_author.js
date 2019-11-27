var coAuthor = (function () {
  var coAuthor = [];
  function Item(id, email, permissions) {
    this.id = id;
    this.email = email;
    this.permissions = permissions;
  }
  function saveCoAuthor() {
    localStorage.setItem("coAuthor", JSON.stringify(coAuthor));
  }
  function loadCoAuthor() {
    coAuthor = JSON.parse(localStorage.getItem("coAuthor"));
    if (coAuthor === null) {
      coAuthor = []
    }
  }
  loadCoAuthor();
  var obj = {};
  obj.addItemToCoAuthor = function (id, email, permissions) {
    var item = new Item(id, email, permissions);
    coAuthor.push(item);
    saveCoAuthor();
  };
  obj.removeItemFromCoAuthor = function (id) { // Removes one item
    for (var i in coAuthor) {
      if (coAuthor[i].id == id) {
        coAuthor.splice(i, 1);
        break;
      }
    }
    saveCoAuthor();
  };
  obj.clearCoAuthor = function () {
    coAuthor = [];
    saveCoAuthor();
  };
  obj.countCoAuthor = function () { // -> return total quantity
    var totalCount = 0;
    for (var i in coAuthor) {
      totalCount += 1;
    }
    return totalCount;
  };
  obj.listCoAuthor = function () { // -> array of Items
    var coAuthorCopy = [];
    for (var i in coAuthor) {
      var item = coAuthor[i];
      var itemCopy = {};
      for (var p in item) {
        itemCopy[p] = item[p];
      }
      coAuthorCopy.push(itemCopy);
    }
    return coAuthorCopy;
  };
  // ----------------------------
  return obj;
})();