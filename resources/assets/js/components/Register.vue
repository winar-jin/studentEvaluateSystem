<template>
  <div class="container">
    <div id='register'>
      <input checked class='nav' name='nav' type='radio'>
      <span class='nav'>学生</span>
      <input class='nav' name='nav' type='radio'>
      <span class='nav'>教师</span>
      <input class='nav' name='nav' type='radio'>
      <span class='nav'>管理员</span>
      <main class='content'>
        <section id='student'>
          <form>
            <ul>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="no">
                    <label>学号</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="name">
                    <label>姓名</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="password">
                    <label>密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="confimPassword">
                    <label>确认密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li class='large padding'>
                <fieldset class='material-button center'>
                  <div>
                    <input class='save' type='button' value='注册' @click="register('student')">
                  </div>
                </fieldset>
              </li>
            </ul>
          </form>
        </section>
        <section id='teacher'>
          <form>
            <ul>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="no">
                    <label>教职工号</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="name">
                    <label>姓名</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="password">
                    <label>密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="confimPassword">
                    <label>确认密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li class='large padding'>
                <fieldset class='material-button center'>
                  <div>
                    <input class='save' type='button' value='注册' @click="register('teacher')">
                  </div>
                </fieldset>
              </li>
            </ul>
          </form>
        </section>
        <section id='admin'>
          <form>
            <ul>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="no">
                    <label>教职工号</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='text' v-model="name">
                    <label>姓名</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="password">
                    <label>密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li>
                <fieldset class='material'>
                  <div>
                    <input required type='password' v-model="confimPassword">
                    <label>确认密码</label>
                    <hr>
                  </div>
                </fieldset>
              </li>
              <li class='large padding'>
                <fieldset class='material-button center'>
                  <div>
                    <input class='save' type='button' value='注册' @click="register('admin')">
                  </div>
                </fieldset>
              </li>
            </ul>
          </form>
        </section>
      </main>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      no: '',
      name: '',
      password: '',
      confimPassword: ''
    }
  },
  methods: {
    // validation(password, confimPassword) {
    //   return password.trim() === confimPassword.trim();
    // },
    register(type) {
      axios.post('register',{
        role:type,
        id:this.no,
        username:this.name,
        password:this.password
      })
      .then(response => {
        console.log(response);
        if(response){
          alert('register success');
        }
      })
      .catch();
      if (true) {
        console.log(`${type} registered: username:${this.name} no:${this.no} password:${this.password}`);
      }
      this.no = '';
      this.name = '';
      this.password = '';
      this.confimPassword = '';
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
$mauve: #575E71;
$heather: #4e5465;
$blush: #454b5a;
$grey: #343434;
$easeOutCubic: cubic-bezier(0.215, 0.610, 0.355, 1.000);
$f: "Microsoft YaHei",
"brandon-grotesque",
"Brandon Grotesque",
"Source Sans Pro",
"Segoe UI",
Frutiger,
"Frutiger Linotype",
"Dejavu Sans",
"Helvetica Neue",
Arial,
sans-serif;
$p: 12px;
*,
*:before,
*:after {
  box-sizing: border-box;
}

* {
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  transform-style: preserve-3d;
}

*:focus {
  outline: none!important;
}

.container {
  height: 100%;
}

.container {
  display: flex;
  align-items: center;
  align-content: center;
  justify-content: center;
  padding: $p;
  background: mix(mix($mauve, $heather), $blush);
  background: linear-gradient(135deg, $mauve 0%, $heather 50%, $blush 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$mauve', endColorstr='$blush', GradientType=1);
  font-family: $f;
  font-size: 16px;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  perspective: 1000px;
}

input,
textarea,
button {
  appearance: none;
  border: 0;
  font-family: $f;
  resize: none;
}

a,
button,
input[type="button"] {
  cursor: pointer;
}

::selection {
  background: rgba($blush, .2);
}

#register {
  opacity: 0;
  transform-origin: center top;
  will-change: opacity, transform;
  animation: rotateIn 1000ms $easeOutCubic 500ms forwards;
  position: relative;
  display: flex;
  flex-flow: row wrap;
  background: white;
  box-shadow: 0 0 20px rgba(darken($mauve, 20%), .2);
  overflow: hidden;
  color: $mauve;
  border-radius: 2px;
  width: 100%;
  max-width: 600px;
  height: 100%;
  @media only screen and (min-width: 500px) {
    max-height: 330px;
  }
}

span.nav {
  transition: all 150ms ease-out;
  flex-basis: 33.333333%;
  display: block;
  position: relative;
  width: 100%;
  padding: $p*1.5 0;
  text-align: center;
  &:nth-of-type(1) {
    z-index: 5;
  }
  &:nth-of-type(2) {
    z-index: 4;
  }
  &:nth-of-type(3) {
    z-index: 3;
  }
  &:nth-of-type(4) {
    z-index: 2;
  }
  &:nth-of-type(5) {
    z-index: 1;
  }
  &:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    right: -1px;
    width: 2px;
    height: 100%;
    background: mix($blush, white, 25%);
  }
  &:last-of-type:after {
    display: none;
  }
}

input.nav {
  cursor: pointer;
  appearance: none;
  opacity: 0;
  position: absolute;
  z-index: 6;
  top: 0;
  width: 33.333333%;
  height: 53px;
  &:hover,
  &:focus {
    +span {
      background: mix($blush, white, 25%);
    }
  }
  &:active,
  &:checked {
    +span {
      background: mix($blush, $mauve);
      color: white;
    }
  }
  &:active {
    +span {
      transition: all 150ms ease-in;
    }
  }
  ~main {
    section {
      transition: all 450ms ease-out;
      transform: translateY(50%) translateZ(0);
      opacity: 0;
      z-index: -1;
    }
  }
  @for $i from 1 through 5 {
    &:nth-of-type(#{$i}) {
      left: $i*33.333333% - 33.333333%;
      &:checked {
        ~main {
          section:nth-of-type(#{$i}) {
            transform: translateY(0) translateZ(0);
            opacity: 1;
            z-index: 10;
          }
        }
      }
    }
  }
}

main {
  align-self: flex-end;
  position: relative;
  border-top: 2px solid mix($blush, white, 25%);
  width: 100%;
  height: calc(100% - 52px);
}

section {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: white;
  will-change: transform, opacity;
  ul {
    display: flex;
    flex-flow: row wrap;
    padding: $p;
    li {
      opacity: 0;
      list-style-type: none;
      transform: translateY(100%) translateZ(0);
      will-change: transform, opacity;
      animation: slideInUp 600ms $easeOutCubic forwards;
      padding: $p/2 $p;
      width: 50%;
      @for $i from 1 through 7 {
        &:nth-child(#{$i}) {
          animation-delay: #{($i*100)+600}ms;
        }
      }
      &.large {
        width: 100%;
      }
      &.padding {
        padding: $p;
      }
    }
  }
}

.material {
  border: none;
  width: 100%;
  div {
    position: relative;
    width: 100%;
    padding-top: $p*1.5;
  }
  label {
    transition: all 150ms ease-out;
    will-change: transform;
    transform: translateZ(0);
    display: block;
    position: absolute;
    z-index: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    padding-bottom: 4px;
    font-weight: 500;
    color: $blush;
    line-height: 1.5;
  }
  hr {
    display: block;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    border: 0;
    border-radius: 4px;
    margin: 0;
    background: mix($grey, white, 10%);
    &:after {
      transition: all 150ms ease-out;
      transform: scaleX(0) translateZ(0);
      transform-origin: left top;
      will-change: transform;
      content: "";
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 4px;
      background: $blush;
    }
  }
  input {
    display: block;
    appearance: none;
    position: relative;
    z-index: 1;
    padding: 0 0 4px;
    margin: 0;
    width: 100%;
    background: none;
    color: $mauve;
    font-size: 16px;
    line-height: 1.5;
    &:focus,
    &:valid {
      +label {
        transform: translateY(-24px) translateZ(0);
        font-size: 12px;
      }
    }
    &:focus {
      ~hr:after {
        transform: scaleX(1) translateZ(0);
      }
    }
  }
}

.material-button {
  width: 100%;
  border: none;
  div {
    width: 100%;
  }
  button,
  input[type="button"] {
    margin: 0;
    border: 0;
    border-radius: 2px;
    padding: $p/2 $p;
    background: mix($grey, white, 10%);
    color: $mauve;
    font-size: 16px;
    transition: all 150ms ease-out;
    &:hover,
    &:focus {
      background: $blush;
      color: white;
    }
    &:active {
      transition: all 150ms ease-in;
      background: $mauve;
    }
    &.save {
      width: 100%;
      max-width: 256px;
      padding: $p $p*2;
      background: mix($blush, $mauve);
      color: white;
      font-size: 18px;
      &:hover,
      &:focus {
        background: $blush;
      }
      &:active {
        background: $mauve;
      }
      @media only screen and (max-height: 444px) {
        display: none;
      }
    }
  }
  &.center {
    div {
      display: flex;
      justify-content: center;
    }
  }
}

@keyframes rotateIn {
  0% {
    opacity: 0;
    transform: rotateX(30deg) rotateY(30deg) translateY(300px) translateZ(200px);
  }
  100% {
    opacity: 1;
    transform: none;
  }
}

@keyframes slideInUp {
  0% {
    opacity: 0;
    transform: translateY(100%) translateZ(0);
  }
  100% {
    opacity: 1;
    transform: none;
  }
}
</style>
