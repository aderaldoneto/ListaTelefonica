export function sanitizePhoneInput(value) {
  return value.replace(/[^0-9()+\s-]/g, '')
}
