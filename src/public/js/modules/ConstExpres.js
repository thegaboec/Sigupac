/**
 * Son las diferentes expresiones regulares
 */
const NUMBER_REG_EXPRE = /(^09[0-9]{8})\b/; // Para verificar un numero telefonico
const EMAIL_REG_EXPRE = /([\w]+)@([a-z]+)\.([a-z])/i; // Para  verificar un correo electronico
const CEDULA_REG_EXPRE = /(?<province>^[01][1-9]|[2][0-4]|30|10|20)(?<tercer>[0-6])(?<number>[0-9]{7})\b/; // para verificar una cedula


export {NUMBER_REG_EXPRE, EMAIL_REG_EXPRE,CEDULA_REG_EXPRE};