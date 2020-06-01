export  class Validation {
    required(input) {
        return input === '' || input === null || input === undefined
    }
}
const  validate = new Validation();
export default validate
