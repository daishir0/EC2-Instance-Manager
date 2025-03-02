# 🚀 EC2 Instance Manager

EC2 Instance Manager is an intuitive web interface that allows you to manage AWS EC2 instances with **one click**. You can efficiently manage multiple EC2 instances from a simple dashboard without having to navigate the complex AWS console or remember CLI commands. It significantly reduces the time and effort required for AWS management by making cost optimization, security management, and resource monitoring easy.

## 💡 Key Features and Benefits

- **Simple Instance Management**: Start, stop, and force stop EC2 instances with one click without opening the complex AWS console
- **Cost Optimization**: Easily stop unused instances and start them as needed to reduce costs
- **Flexible Instance Type Changes**: Easily switch between predefined standard and enhanced types based on load (e.g., t3a.medium for low load, t3a.large for high load)
- **One-Click Security Management**: Toggle SSH (Linux) or RDP (Windows) port access control with a single button
- **Real-Time Status Monitoring**: Visually display instance status and type with color coding, automatically updated every 15 seconds
- **Fully Responsive Design**: Comfortable operation on any device from desktop to smartphone
- **Bulk Management**: Manage multiple instances across multiple regions on a single screen

## ⚙️ Requirements

- PHP 7.0 or higher
- AWS SDK for PHP
- AWS account and access rights to EC2 instances
- Valid AWS credentials (Access Key ID and Secret Access Key)

## 🔧 Installation (Completed in 5 Minutes)

1. Clone or download this repository
   ```
   git clone https://github.com/daishir0/ec2-instance-manager.git
   ```

2. Install AWS SDK using Composer:
   ```
   composer require aws/aws-sdk-php
   ```

3. Edit the `index.php` file to set the following information:
   - BASIC authentication username and password (be sure to change for security)
   - AWS credentials (Access Key ID and Secret Access Key)
   - Information about the EC2 instances you want to manage (ID, name, region, instance types, etc.)

## 📱 Usage

1. Place the index.php file in the public directory of your web server (Apache, Nginx, etc.)

2. Access with your browser and log in with BASIC authentication

3. An intuitive dashboard will be displayed, allowing you to perform the following operations with one click for each instance:
   - **Start**: Instantly start an instance (convenient for beginning work in the morning)
   - **Stop**: Safely stop an instance (optimal for cost reduction)
   - **Force Stop**: Forcibly stop an unresponsive instance (for emergencies)
   - **Modify Type**: Automatically change to the instance type selected in the dropdown (easy scaling according to load)
   - **Connectable/Unconnectable**: Toggle SSH/RDP port access control with one click (open ports only when needed to enhance security)

4. Instance states are color-coded for at-a-glance status:
   - Green: Running (standard type)
   - Dark Green: Running (enhanced type)
   - Red: Stopped

## 🔒 Security Notes

- It is strongly recommended to use this tool within a protected network with VPN or IP restrictions, rather than exposing it directly to the internet
- Use complex passwords for BASIC authentication and change them regularly
- Create and use an IAM user with the following minimal permissions for AWS credentials:
  - `ec2:DescribeInstances`
  - `ec2:StartInstances`
  - `ec2:StopInstances`
  - `ec2:ModifyInstanceAttribute`
  - `ec2:DescribeSecurityGroups`
  - `ec2:AuthorizeSecurityGroupIngress`
  - `ec2:RevokeSecurityGroupIngress`
- We recommend having a security expert review before using in a production environment

## 🎨 Customization and Extension

- **Instance Management**: Simply edit the `$instances` array to easily add or remove EC2 instances you want to manage
- **Appearance Customization**: Customize the UI design to match your company's brand colors by editing the CSS
- **Feature Extensions**: Easily add features such as:
  - Scheduled automatic start/stop
  - Cost monitoring and budget alerts
  - Multiple AWS account management
  - Integrated display of CloudWatch metrics
  - SNS notification integration

## 💼 Business Benefits

- **Cost Reduction**: Reduce AWS usage costs by up to 30% by stopping unused instances and changing instance types as needed
- **Operational Efficiency**: Eliminate the need for complex AWS console operations and significantly reduce EC2 management time
- **Enhanced Security**: Minimize security risks by opening SSH/RDP ports only when needed
- **Reduced Training Costs**: Easy operation with an intuitive UI, even without specialized AWS knowledge

## 📜 License

This project is released under the MIT License. See the LICENSE file for details.

## 🙏 Feedback

Please submit bug reports and feature requests through the GitHub Issues page. Pull requests are also welcome!

---

# 🚀 EC2 Instance Manager

EC2 Instance Managerは、AWSのEC2インスタンスを**ワンクリック**で管理できる直感的なウェブインターフェースです。AWSコンソールの複雑な操作やCLIコマンドを覚える必要なく、シンプルなダッシュボードから複数のEC2インスタンスを効率的に管理できます。コスト最適化、セキュリティ管理、リソース監視が簡単に行えるため、AWS管理の時間と手間を大幅に削減します。

## 💡 主な機能と利点

- **シンプルなインスタンス管理**: 複雑なAWSコンソールを開かずに、ワンクリックでEC2インスタンスの起動、停止、強制停止が可能
- **コスト最適化**: 使用していないインスタンスを簡単に停止し、必要に応じて起動することでコスト削減が可能
- **インスタンスタイプの柔軟な変更**: 負荷に応じて事前定義された標準タイプと拡張タイプの間で簡単に切り替え可能（例：低負荷時はt3a.medium、高負荷時はt3a.large）
- **ワンクリックセキュリティ管理**: SSH（Linux）またはRDP（Windows）ポートのアクセス制御をボタン一つで切り替え可能
- **リアルタイム状態監視**: 15秒ごとに自動更新されるインスタンスの状態とタイプをカラーコード付きで視覚的に表示
- **完全レスポンシブデザイン**: デスクトップからスマートフォンまで、あらゆるデバイスで快適に操作可能
- **一括管理**: 複数リージョンの複数インスタンスを一画面で管理可能

## ⚙️ 必要条件

- PHP 7.0以上
- AWS SDK for PHP
- AWSアカウントとEC2インスタンスへのアクセス権限
- 有効なAWS認証情報（アクセスキーIDとシークレットアクセスキー）

## 🔧 インストール方法（5分で完了）

1. このリポジトリをクローンまたはダウンロードします
   ```
   git clone https://github.com/daishir0/ec2-instance-manager.git
   ```

2. Composerを使用してAWS SDKをインストールします:
   ```
   composer require aws/aws-sdk-php
   ```

3. `index.php`ファイルを編集して、以下の情報を設定します:
   - BASIC認証のユーザー名とパスワード（セキュリティのため必ず変更してください）
   - AWS認証情報（アクセスキーIDとシークレットアクセスキー）
   - 管理したいEC2インスタンスの情報（ID、名前、リージョン、インスタンスタイプなど）

## 📱 使用方法

1. index.phpファイルをウェブサーバー（Apache、Nginxなど）の公開ディレクトリに配置します

2. ブラウザでアクセスし、BASIC認証でログインします

3. 直感的なダッシュボードが表示され、各インスタンスに対して以下の操作がワンクリックで可能です:
   - **Start**: インスタンスを即座に起動（朝の業務開始時に便利）
   - **Stop**: インスタンスを安全に停止（コスト削減に最適）
   - **Force Stop**: 応答しないインスタンスを強制的に停止（緊急時に）
   - **Modify Type**: ドロップダウンで選択したインスタンスタイプに自動的に変更（負荷に応じたスケーリングが簡単）
   - **Connectable/Unconnectable**: SSH/RDPポートのアクセス制御をワンクリックで切り替え（必要な時だけポートを開放し、セキュリティを強化）

4. インスタンスの状態は色分けされ、一目で状況を把握できます:
   - 緑色: 実行中（標準タイプ）
   - 濃い緑色: 実行中（拡張タイプ）
   - 赤色: 停止中

## 🔒 セキュリティ上の注意

- このツールはインターネットに直接公開せず、VPNやIP制限などで保護されたネットワーク内で使用することを強く推奨します
- BASIC認証には複雑なパスワードを使用し、定期的に変更してください
- AWS認証情報は以下の最小限の権限を持つIAMユーザーを作成して使用してください:
  - `ec2:DescribeInstances`
  - `ec2:StartInstances`
  - `ec2:StopInstances`
  - `ec2:ModifyInstanceAttribute`
  - `ec2:DescribeSecurityGroups`
  - `ec2:AuthorizeSecurityGroupIngress`
  - `ec2:RevokeSecurityGroupIngress`
- 本番環境で使用する前に、セキュリティ専門家によるレビューを受けることをお勧めします

## 🎨 カスタマイズと拡張

- **インスタンス管理**: `$instances`配列を編集するだけで、管理したいEC2インスタンスを簡単に追加・削除できます
- **外観のカスタマイズ**: CSSを編集することで、企業のブランドカラーに合わせたUIデザインにカスタマイズ可能
- **機能拡張**: 以下のような機能を簡単に追加できます:
  - スケジュールによる自動起動/停止
  - コスト監視と予算アラート
  - 複数のAWSアカウント管理
  - CloudWatchメトリクスの統合表示
  - SNS通知の統合

## 💼 ビジネスメリット

- **コスト削減**: 使用していないインスタンスの停止や、必要に応じたインスタンスタイプの変更により、AWS利用コストを最大30%削減可能
- **運用効率化**: AWSコンソールの複雑な操作が不要になり、EC2管理の時間を大幅に削減
- **セキュリティ強化**: 必要な時だけSSH/RDPポートを開放することで、セキュリティリスクを最小限に抑制
- **トレーニングコスト削減**: 直感的なUIにより、AWSの専門知識がなくても簡単に操作可能

## 📜 ライセンス

このプロジェクトはMITライセンスの下で公開されています。詳細については、LICENSEファイルを参照してください。

## 🙏 フィードバック

バグ報告や機能リクエストは、GitHubのIssuesページからお願いします。プルリクエストも歓迎します！
