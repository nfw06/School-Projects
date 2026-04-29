#include <iostream>
#include <array>

std::array<int, 8> convert_sbox(std::array<int, 8>& blocco);
std::array<int, 4> to_binary(int& number);
std::array<int, 4> sbox(std::array<int, 4>& gruppo);
int to_decimal(std::array<int, 4>& gruppo);

int main() {
  std::array<int, 8> blocco {1, 0, 1, 1, 0, 0, 1, 0};
  std::cout << '\n';

  std::array<int, 8> result = convert_sbox(blocco);

  for (int i = 0; i < result.size(); i++) {
    std::cout << result[i];
  }
  std::cout << '\n';

  return 0;
}

int to_decimal(std::array<int, 4>& gruppo) {
  int decimale {};
  for (int i = 0; i < 4; i++) {
    decimale += gruppo[i] * (8 >> i);
  }
  return decimale;
}

std::array<int, 4> to_binary(int& number) {
  std::array<int, 4> bits;
  for (int i = 0; i < 4; i++) {
    bits[i] = (number >> (3 - i) & 1);
  }
  return bits;
}

std::array<int, 4> sbox(std::array<int, 4>& gruppo) {
  std::array<int, 16> tabella = {9, 4, 10, 11, 13, 1, 8, 5, 6, 2, 0, 3, 12, 14, 15, 7};
  int index {to_decimal(gruppo)};
  std::array<int, 4> result {to_binary(tabella[index])};
  return result;
}

std::array<int, 8> convert_sbox(std::array<int, 8>& blocco) {
  std::array<int, 8> result {};
  std::array<int, 4> temp_gruppo {};
  int temp_index {}, result_index {};
  for (int i = 0; i < blocco.size(); i++) {
    temp_gruppo[temp_index++] = blocco[i];
    if (temp_index == 4) {
      std::array<int, 4> sbox_result = sbox(temp_gruppo);
      temp_index = {};
      for (int j = 0; j < sbox_result.size(); j++) {
        result[result_index++] = sbox_result[j];
      }
    }
  }
  return result;
}


