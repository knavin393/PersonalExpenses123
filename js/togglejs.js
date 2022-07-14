function getPasswordStrength(password){
  let s = 0;
  if(password.length > 6){
    s++;
  }
  if(password.length > 10){
    s++;
  }
  if(/[A-Z]/.test(password)){
    s++;
  }
  if(/[0-9]/.test(password)){
    s++;
  }
  if(/[^A-Za-z0-9]/.test(password)){
    s++;
  }
  return s;
}
document.querySelector(".input-group #password").addEventListener("focus",function(){
  document.querySelector(".input-group .pw-strength").style.display = "block";
});

document.querySelector(".input-group #password").addEventListener("keyup",function(e){
  let password = e.target.value;
  let strength = getPasswordStrength(password);
  let passwordStrengthSpans = document.querySelectorAll(".input-group .pw-strength span");
  strength = Math.max(strength,1);
  passwordStrengthSpans[1].style.width = strength*20 + "%";
  if(strength < 2){
    passwordStrengthSpans[0].innerText = "Weak";
    passwordStrengthSpans[0].style.color = "white";
    passwordStrengthSpans[1].style.background = "red";
  } else if(strength >= 2 && strength <= 4){
    passwordStrengthSpans[0].innerText = "Medium";
    passwordStrengthSpans[0].style.color = "white";
    passwordStrengthSpans[1].style.background = "yellow";
  } else {
    passwordStrengthSpans[0].innerText = "Strong";
    passwordStrengthSpans[0].style.color = "white";
    passwordStrengthSpans[1].style.background = "#20a820";
  }
});

const pass = document.querySelector('#password')
        const btn = document.querySelector('#togglePassword')

        btn.addEventListener('click', () => {
            if (password.type === "text") {
                password.type = "password";
                btn.innerHTML = "visibility";
            } else {
                password.type = "text";
                btn.innerHTML = "visibility_off";

            }
        })