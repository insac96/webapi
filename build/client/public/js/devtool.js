((function () {
  var callbacks = [], timeLimit = 50, open = false;
  setInterval(loop, 1);
  
  return {
    addListener: function (fn) {
      callbacks.push(fn);
    },
    cancleListenr: function (fn) {
      callbacks = callbacks.filter(function (v) {
        return v !== fn;
      });
    }
  }

  function loop() {
    var startTime = new Date();
    debugger;

    if (new Date() - startTime > timeLimit) {
      if (!open) {
        callbacks.forEach(function (fn) {
          fn.call(null);
        });
      }
      open = true;
      window.stop();
      alert('Đừng cố gắng tò mò, hãy chỉ chơi game thôi nhé bạn');
      document.body.innerHTML = "";
      window.location.reload();
    } else {
      open = false;
    }
  }
})()).addListener(function () {
  window.location.reload();
});
